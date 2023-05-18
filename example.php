<?php

# Include the Validator class into your project
include 'Validator.php';

# Instantiate an instance of the Validator class
$validator = new Validator();

// Validation methods

# Set the name and value of to be validated
$firstName = 'John';
$validator->set('first_name', $firstName);

# Call the validator method you need
$validator->not_empty();

# For readability, methods can be chained together
$lastName = 'Smith';

$validator->set('last_name', $lastName)->not_empty();

# Custom error messages can also be declared
$email = 'john@msn';

$validator->set('email', $email)->is_email('Please provide a valid Email Address');

# And multiple validation types can be used on a single field:
$address = '123 Main';

$validator->set('street_address', $address)->not_empty('Street Address is required')->min(10, 'Street address needs to be at least 10 characters long');

# Check if the values are valid
if ($validator->hasErrors()) {
    // Some fields are not valid
    print_r($validator->get_errors());
} else {
    echo 'No errors';
}

// ************************SAMPLE OF ALL VALIDATION METHODS*********************** //

$validator->set('name', '')->not_empty('Name is required'); // Value is invalid
$validator->set('email', 'john@msn.com')->is_email('Please provide a valid email'); // Value is valid
$validator->set('street', '123 Ramona')->min(12, 'Street needs to be at least 12 characters'); // Value is invalid
$validator->set('city', 'Pittsburgh')->max(25, 'City must be less than 25 characters'); // Value is valid
$validator->set('website', 'http://www.test.com/')->is_url('Please provide a valid URL'); //Value is valid
$validator->set('age', 'fourteen')->is_num('Age must be a number'); // Value is invalid
$validator->set('password', 'abcdef123@')->is_alphanumeric('Password must contain only letters and numbers'); // Value is invalid
$validator->set('is_minor', true)->is_boolean('Value must be a boolean (true or false)'); // Value is valid
$validator->set('captcha', 'apple pie')->is_equal('cheesecake', 'Value must be apple pie'); //Value is invalid
$validator->set('favorite_color', 'pink')->contains(['red', 'blue', 'green'], ',', 'Value must be red, blue, or green'); // Value is invalid
$validator->set('phone', 555 - 234 - 5678)->is_phone('Valid phone number required'); // Value is valid
$validator->set('zip', 90210)->is_zip('Valid zip code is required'); // Value is valid
$validator->set('ip_address', '172.0.0.1')->is_ip('Valid IP address is required'); // Value is valid

$errors = $validator->hasErrors() ? $validator->get_errors() : null;

foreach ($errors as $error => $message) {
    echo "<p>$error: $message</p>";
}