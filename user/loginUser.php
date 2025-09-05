<?php

require_once "../api/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "usman clothing service" ?></title>
   <link rel="stylesheet" href="styles.css">
</head>

<body>


    <form action="">
        <div class="input_f">
            <input type="email" name="email" id="email" class="input" />
        </div>

        <div class="input_f">
            <input type="password" name="password" id="password" class="input" />
        </div>

        <a href="signUpUser.php">signup here</a>
    </form>
</body>

</html>