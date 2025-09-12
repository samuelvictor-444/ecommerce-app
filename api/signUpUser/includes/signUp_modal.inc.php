<?php

declare(strict_types=1);

// function that checks if email exists
function get_email(string $userEmail, object $pdo)
{
    $query = "SELECT * FROM users WHERE email = :email";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $userEmail);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
} // ends function that checks if email exists

// function that checks if phoneNumber exists
function get_phone(string $userPhone, object $pdo)
{
    $query = "SELECT * FROM users WHERE phoneNumber = :phoneNumber";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":phoneNumber", $userPhone);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
} // ends function that checks if phoneNumber exists

// function that create user account
function set_user(object $pdo, string $firstName, string $lastName, string $userEmail, string $userPhone, string $userDateOfBirth, string $userGender, string $userPwd)
{
    $query = "INSERT INTO users (firstName , lastName , email , phoneNumber , gender , dateOfBirth , userPassword , lastLogin)
     Values(:firstName , :lastName , :email , :phoneNumber , :gender , :dateOfBirth , :userPassword , NOW())";

    $hashPwd = password_hash($userPwd, PASSWORD_DEFAULT);

    $stmt  = $pdo->prepare($query);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":lastName", $lastName);
    $stmt->bindParam(":email", $userEmail);
    $stmt->bindParam(":phoneNumber", $userPhone);
    $stmt->bindParam(":gender", $userGender);
    $stmt->bindParam(":dateOfBirth", $userDateOfBirth);
    $stmt->bindParam(":userPassword", $hashPwd);

    $stmt->execute();
} // ends function  that create user account