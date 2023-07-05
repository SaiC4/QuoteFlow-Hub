<?php

function sanitize_email($email = "") {      // This function sanitizes the email
    
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);     // "trim()" removes whitespace from user input
}

function is_valid_email($email = "") {      // This function verifies if the email is valid, returns true or false
    
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);     // "trim()" removes whitespace from user input
}

/* 
    Data sanitization is a built-in feature for PHP that is used to remove illegal characters from the usual data types in the input,
    like alphabet characters from number input, to validate the inputs better. This makes data validation easier without having to 
    create a bunch of if-else statements for validation instead. 

    This W3Schools link shows the various sanitization commands and their purpose:
    https://www.w3schools.com/php/php_ref_filter.asp 
*/