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
    $query = "SELECT id, firstName, email, middleName, userPassword , lastName , phoneNumber , gender , dateOfBirth FROM users WHERE email = :email";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $userEmail);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function update_user_info(string $userFirstName, string $userLastName, string $middleName, string $userGender, string $userDOB, string  $userPhone, string $userEmail, object $pdo)
{
    $update_user_query = "UPDATE users SET firstName = :firstName, lastName = :lastName, middleName = :middleName, gender = :gender, dateOfBirth = :dateOfBirth, phoneNumber = :phoneNumber WHERE email = :email";

    $stmt = $pdo->prepare($update_user_query);
    $stmt->bindParam(":firstName", $userFirstName);
    $stmt->bindParam(":lastName", $userLastName);
    $stmt->bindParam(":middleName", $middleName);
    $stmt->bindParam(":gender", $userGender);
    $stmt->bindParam(":dateOfBirth", $userDOB);
    $stmt->bindParam(":email", $userEmail);
    $stmt->bindParam(":phoneNumber",  $userPhone);



    if ($stmt->execute()) {
        return $stmt->rowCount() > 0;
    }

    return false;
}
