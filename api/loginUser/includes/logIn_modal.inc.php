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

function get_user(string $userEmail, object $pdo)
{
     $query = "SELECT id, firstName, email, userPassword , lastName , phoneNumber , gender , dateOfBirth FROM users WHERE email = :email";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email" ,$userEmail);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}
