<?php 


declare(strict_types=1);


// function that check if input are empty
function is_input_empty(string $userEmail)
{
    if ( empty($userEmail)) {
        return true;
    } else {
        return false;
    }
} // ends function that check if input are empty

// function is_email_vaild
function is_email_valid(string $userEmail)
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


function is_password_wrong(string $userPwd , string $hashedPwd ) {
  if(!password_verify($userPwd , $hashedPwd)) {
    return true;
  }else {
    return false;
  }
}

