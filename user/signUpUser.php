<?php

//require_once "../api/config_session.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | Aba Price Online Shopping</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <div class="container_wrapper_sign_in_sign_up">
        <div class="header_l">
            <img src="../assets/images/acc_logo.png" class="logo" alt="">
        </div>


        <div class="card" id="user_log_box">
            <div class="progress_x">
                <div class="slide"></div>
            </div>

            <form id="createUser">
                <div class="container_iden">
                    <div class="center">
                        <h2>Welcome to Aba Price</h2>
                        <p class="subheading" id="subH">Please enter your registered email address below to securely access your account and continue to our services</p>
                    </div>

                    <div class="flelds">

                        <div class="input_f">
                        </div>

                        <div id="input_">
                            <div class="identifiyer_d">
                                <input type="text" name="firstName" id="firstName" class="input_user" placeholder="enter first name" />
                            </div>
                            <p></p>
                        </div>


                        <div id="input_">
                            <div class="identifiyer_d">
                                <input type="text" name="lastName" id="lastName" class="input_user" placeholder="enter last name" />
                            </div>
                            <p></p>
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
                    </div>

                    <button type="button" id="signInBtn">create account</button>

                    <a href="./loginUser.php?redirect=<?php echo htmlspecialchars($_GET['redirect'] ?? '../index.php');  ?>">login here</a>


                </div>
            </form>
        </div>


    </div>
    <script src="javascript/createUser.js"></script>
</body>

</html>