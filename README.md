# PHP Validator

This is a simple PHP class for validating data. This validator can be used to validate form data, or any other kind of data in PHP.

This validator is easy to use and is very versatile - with 13 of the most common validation types.

## Installation
To use this Validation class in your PHP project, simply download the ```Validator.php``` file from Github and add it to your project directory.

Once in your project directory, include the file into your project.

## How To Use
Include ```Validator.php``` class into your project, and then create an instance of it, similar to the example below:

```php
<?php
   include 'Validator.php';
   $validator = new Validator();
```

#### Validating Data
Since each validator method returns an instance of itself, you can chain methods together to save lines of code, and thus reduce file size.

As an example, let's say that we have a 'name' field, and that this field is required (cannot be null), and it must also be at least 3 characters in length. Our code for this could look like the following:

```php
$name = 'John';
$validator->set('name', $name)->not_empty()->min_length(3); //Field is valid
```

Here is another example of a field that will return invalid:

```php
$email = 'john@msn';
$validator->set('email', $email)->is_email(); // Not valid
```

#### Custom Error Messages
Custom error messages can by added to each validation method by simply passing them in as a function parameter:

```php
$email = 'john@msn';
$validator->set('email', $email)->is_email('Please provide a valid email address');
```

Instead of returning a generic error message ('Valid email address is required'), this method will return your custom error message (in this case, 'Please provide a valid email address').

#### Catching Errors
After declaring all validation methods, you can determine if any errors were caught by calling the hasErrors() method:

```php
$validator->hasErrors() // Will return true if any errors are found in the validation methods.
```

Errors can be caught by calling the get_errors method:

```php
$validator->get_errors(); // Will return an array of all of the validation errors
```

You can grab a specific field error by passing in the name that you defined for the field in the set() method:

```php
$validator->get_errors('email'); // Will get the error for the field named 'email'. If there is no error, will return false.
```

### Methods

Below is a list of validator methods currently available:

* not_empty --> Will ensure that the field contains a value.
* min --> Will ensure that the value passed in has a minimum length.
* max --> Will ensure that the value passed in has a maximum length.
* is_email --> Will ensure that the value passed in is a valid email address format.
* is_url --> Will ensure that the value passed in is a valid url format.
* is_num --> Will ensure that the value passed in contains only numbers.
* is_alphanumeric --> Will ensure that the value passed in contains only numbers and letters.
* is_boolean --> Will ensure that the value passed in is a boolean value (either true or false).
* is_equal --> Will ensure that the value passed in is equal to the parameter value
* contains --> Will compare the string against an array or a single value to ensure that the passed in value contains a value from the passed in parameter.
* is_phone --> Will ensure that the passed in value is a valid US phone number format.
* is_ip --> Will ensure that the passed in value is a valid IP address format.

### Notes
Be sure to check this repo often, as I plan to continue to add new validation methods to this class as I find a need for them.

## History

Version 1.0.1 (05-17-2023) - Core MVP application with basic validation methods.


## Credits
The functions within this Validator class are a collection of different functions and methods from across the internet by various developers, culminated together into one easy-to-use class. When possible, credit will be given to those developers whom the methods are based off of.

Lead Developer - Patrick McDermott (@pjmcdermott92)

Inspired by - Rafael Wendel Pinheiro (@rafaelwendel)

## License
The MIT License (MIT)

Copyright (c) 2023 by PJMcDermott (@pjmcdermott92)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.