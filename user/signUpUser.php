<?php

//require_once "../api/config_session.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "usman clothing service" ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>


    <form id="createUser">

        <div class="input_f">
            <input type="text" name="firstName" id="firstName" class="input" placeholder="enter first name" />
        </div>

        <div class="input_f">
            <input type="text" name="lastName" id="lastName" class="input" placeholder="enter last name" />
        </div>

        <div class="input_f">
            <input type="email" name="email" id="email" class="input" placeholder=" enter email" />
        </div>

        <div class="input_f">
            <input type="tel" name="phone" id="phone" class="input" placeholder=" enter phone number" />
        </div>

        <div class="input_f">
            <input type="date" name="dateOfBirth" id="dateOfBirth" class="input" placeholder="" />
        </div>

        <div class="input_f">
            <select name="gender" id="gender">
                <option value="" disabled selected>Select gender</option>
                <option value="male">Male</option>
                <option value="female">female</option>
            </select>
        </div>


        <div class="input_f">
            <input type="password" name="password" id="password" class="input" placeholder="enter password" />
        </div>

        <button type="button" id="signInBtn">create account</button>

        <a href="./loginUser.php?redirect=<?php echo htmlspecialchars($_GET['redirect'] ?? 'index.php');  ?>">login here</a>
    </form>

    <script src="javascript/createUser.js"></script>
</body>

</html>