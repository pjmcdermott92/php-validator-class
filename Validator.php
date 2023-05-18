<?php

/**
 * Copyright (c) 2023 by PJMcDermott (@pjmcdermott92)
 * 
 * MIT License
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class Validator
{
    /**
     * @var $data Field and value to be checked
     * @access protected
     */
    protected $data = array();

    /**
     * @var $errors Field and value to be checked
     * @access protected
     */
    protected $errors = array();

    /**
     * @var $errorMessages Array of default error messages
     * @access protected
     */
    protected $messages = array();

    public function __construct()
    {
        $this->set_default_errors();
    }

    /**
     * Set a field to be validated
     * 
     * @param string $name The name of the field
     * @param mixed $value The value of the field
     * @return $this
     */
    public function set($field, $value)
    {
        $this->data['name'] = $field;
        $this->data['value'] = $value;

        return $this;
    }

    /**
     * Ensure field is not empty
     * 
     * @param string $message Optional custom error message
     * @return $this;
     */
    public function not_empty($message = null)
    {
        if (empty($this->data['value'])) {
            $error = isset($message) ? $message : $this->messages['not_empty'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure length of value is at least param
     * 
     * @param int $length = Minimum length
     * @param string $message Optional custom error message
     * @return $this;
     */
    public function min($length, $message = null)
    {
        $valueToString = (string) $this->data['value'];
        if (strlen($valueToString) < $length) {
            $error = isset($message) ? $message : sprintf($this->messages['min_length'], $length);
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure length of value is no more than param
     * 
     * @param int $length = Maximum length
     * @param string $message Optional custom error message
     * @return $this;
     */
    public function max($length, $message = null)
    {
        $valueToString = (string) $this->data['value'];
        if (strlen($valueToString) > $length) {
            $error = isset($message) ? $message : sprintf($this->messages['max_length'], $length);
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value is a valid email address
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_email($message = null)
    {
        if (filter_var($this->data['value'], FILTER_VALIDATE_EMAIL) === false) {
            $error = isset($message) ? $message : $this->messages['email'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value is a valid URL
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_url($message = null)
    {
        if (filter_var($this->data['value'], FILTER_VALIDATE_URL) === false) {
            $error = isset($message) ? $message : $this->messages['url'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value only contains numbers
     * 
     * @param string $message Optional custom error message
     * @return $this;
     */
    public function is_num($message = null)
    {
        if (!is_numeric($this->data['value'])) {
            $error = isset($message) ? $message : $this->messages['num'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value only contains alphanumeric characters
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_alphanumeric($message = null)
    {
        $regex = '/^(\s|[a-zA-Z0-9])*$/';
        $value = (string) $this->data['value'];
        if (!preg_match($regex, $value)) {
            $error = isset($message) ? $message : $this->messages['alphanumeric'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure that value is a boolean (True or False)
     * 
     * @param string $message Optional custom error message
     * @return $this;
     */
    public function is_boolean($message = null)
    {
        if (!is_bool($this->data['value'])) {
            $error = isset($message) ? $message : $this->messages['boolean'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value equals param
     * 
     * @param $value Value to match
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_equal($value, $message = null)
    {
        if (!$this->data['value'] == $value) {
            $message = isset($message) ? $message : $this->messages['not_equal'];
            $this->set_error($message);
        }

        return $this;
    }

    /**
     * Ensure value contains element from param
     * 
     * @param $values The value(s) to contain
     * @param $value separator
     * @param string $message Optional custom error message
     * @return $this
     */
    public function contains($values, $separator = false, $message = null)
    {
        if (!is_array($values)) {
            if (!$separator || is_null($values)) {
                $values = array();
            } else {
                $values = explode($separator, $values);
            }
        }

        if (!in_array($this->data['value'], $values)) {
            $error = isset($message) ? $message : $this->messages['contains'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value is a valid Phone Number
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_phone($message = null)
    {
        $valid = preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/', $this->data['value']);
        if (!$valid) {
            $error = isset($message) ? $message : $this->messages['phone'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value is a valid Zip Code
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_zip($message = null)
    {
        $valid = preg_match('/^[0-9]{5}$/', $this->data['value']);
        if (!$valid) {
            $error = isset($message) ? $message : $this->messages['zip_code'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Ensure value is a valid IP Address
     * 
     * @param string $message Optional custom error message
     * @return $this
     */
    public function is_ip($message = null)
    {
        if (filter_var($this->data['value'], FILTER_VALIDATE_IP) === false) {
            $error = isset($message) ? $message : $this->messages['ip_address'];
            $this->set_error($error);
        }

        return $this;
    }

    /**
     * Return true if there are errors
     */
    public function hasErrors()
    {
        return count($this->errors) > 0 ? true : false;
    }

    /**
     * Return the array of errors
     * To get a single field error, pass the name in as a param
     * 
     */
    public function get_errors($fieldName = false)
    {
        if ($fieldName) {
            if (isset($this->errors[$fieldName])) {
                return $this->errors[$fieldName];
            } else {
                return false;
            }
        } else {
            if ($this->hasErrors()) {
                return $this->errors;
            }
        }

        return false;
    }


    // PRIVATE HELPER METHODS

    /**
     * Set error messages to their defaults
     * 
     * @access protected
     * @return void
     */
    protected function set_default_errors()
    {
        $this->messages = array(
            'not_empty' => 'Required field',
            'min_length' => 'Field must contain at least %s characters',
            'max_length' => 'Field must no more than %s characters',
            'email' => 'Valid Email Address required',
            'url' => 'Valid URL required',
            'num' => 'Value contain only numbers',
            'alphanumeric' => 'Value must contain only numbers and letters',
            'boolean' => 'Value must be a boolean (True or False)',
            'not_equal' => 'Value must equal %s',
            'contains' => 'Value must contain a specified item',
            'phone' => 'Valid Phone Number required',
            'zip_code' => 'Valid Zip Code required',
            'ip_address' => 'Valid IP Address required'
        );
    }

    /**
     * Set Error message
     * 
     * @access protected
     * @param $error = Error
     * @return void
     */
    public function set_error($error)
    {
        $this->errors[$this->data['name']] = $error;
    }
}