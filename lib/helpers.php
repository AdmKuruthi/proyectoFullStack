<?php
// helpers.php
// This file contains helper functions for the application


/* Method detectors*/
function isPost()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function isGet()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

/* Validations */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isValidUsername($username)
{
    return preg_match('/^[a-zA-Z0-9_]{2,20}$/', $username);
}
function isValidPassword($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/', $password);
}
function isValidPhone($phone)
{
    return preg_match('/^\+?[0-9]{10,15}$/', $phone);
}
?>