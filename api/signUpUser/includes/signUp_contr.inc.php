<?php

declare(strict_types=1);


// function that check if input are empty
function is_input_empty(string $firstName, string $lastName, string $userEmail, string $userPhone, string $userDateOfBirth, string $userGender, string $userPwd)
{
    if (empty($firstName) || empty($lastName) || empty($userEmail) || empty($userPhone) || empty($userDateOfBirth) || empty($userGender) || empty($userPwd)) {
        return true;
    } else {
        return false;
    }
} // ends function that check if input are empty

// function is_email_vaild
function is_email_vaild(string $userEmail)
{
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
} // ends function is_email_vaild


function is_email_registered(string $userEmail, object $pdo)
{
    if (get_email($userEmail, $pdo)) {
        return true;
    } else {
        return false;
    }
} // ends function is_email_registered

function is_phoneNumber_registered(string $userPhone, object $pdo)
{
    if (get_phone($userPhone, $pdo)) {
        return true;
    } else {
        return false;
    }
} // ends function is_email_registered

function create_user(object $pdo, string $firstName, string $lastName, string $userEmail, string $userPhone, string $userDateOfBirth, string $userGender, string $userPwd)
{
    set_user($pdo, $firstName,  $lastName,  $userEmail,  $userPhone,  $userDateOfBirth,  $userGender,  $userPwd);
}
