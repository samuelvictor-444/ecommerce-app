<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="./css/styles.css">
    <script src="../assets/javascript/jquery.js"></script>
</head>

<body>
    <!------------------------------- HERE BRGINS THE SIGN IN CONTAINER WRAPPER  -------------------------->

    <div class="container_wrapper_sign_in_sign_up">
        <div class="header_l">
            <img src="../assets/images/acc_logo.png" class="logo" alt="">
        </div>


        <div class="card" id="user_log_box">

            <div class="progress_x">
                <div class="slide"></div>
            </div>
            <form id="loginUser">
                <div class="container_iden">
                    <div class="center">
                        <h2>Welcome to Aba Price</h2>
                        <p class="subheading" id="subH">Please enter your registered email address below to securely access your account and continue to our services</p>
                    </div>

                    <div class="flelds">

                        <input type="hidden" id="hiddenEmail" name="userEmail">

                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? 'index.php'); ?>">


                        <div id="email_input">
                            <div class="identifiyer_d">
                                <input type="email" placeholder="Enter Your Email " id="userEmail" class="input_user" required>
                            </div>
                            <p></p>
                        </div>

                        <div id="pwd_input">
                            <div class="identifiyer_d">
                                <input type="password" placeholder="Enter Your password " name="password" id="password" class="input_user" required>
                            </div>
                            <p></p>
                        </div>
                    </div>

                    <div class="controls">
                        <div class="btn_contrl">
                            <button id="Continue" type="button" class="cont_btn">Continue</button>
                        </div>

                        <div class="disclaimer">
                            <label>By continuing you agree to Aba Price</label>
                            <br>
                            <a href="" class="terms_con" target="_blank">Terms and Conditions</a>
                        </div>
                    </div>

                    <div class="bottom_conta">
                        <div class="social_login">
                            <div class="login_mdc">
                                <button id="facebook" class="_log_face">
                                    <span>Log in with Facebook</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="_not_ice">
                        <div>
                            <p class="_notice">For further support, you may visit the Help Center or contact our customer service team.</p>
                        </div>
                    </div>

                    <div class="log_bott">
                        <img src="../images/icon2.png" alt="" width="24px">
                    </div>

                </div>
            </form>
        </div>

        <div class="card" id="otp_verify">

            <div class="progress_x ">
                <div class="slide"></div>
            </div>
            <form id="user_verify_otp">
                <div class="container_iden">
                    <div class="center">
                        <h2>Verification Code</h2>
                        <p class="subheading" id="otp-message"></p>
                    </div>

                    <div class="flelds verify_otp_con">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? 'index.php'); ?>">

                        <div id="email_input" class="otp_verify_n">
                            <div class="identifiyer_d">
                                <input maxlength="1" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                        </div>

                        <p id="otp_error_msg"></p>
                    </div>

                    <div class="controls">
                        <div class="btn_contrl">
                            <button id="verify_opt" type="button" class="cont_btn">verify opt</button>
                        </div>


                    </div>






                </div>
            </form>
        </div>
    </div>

    <!------------------------------- HERE ENDS THE SIGN IN CONTAINER WRAPPER  -------------------------->
    <script src="./javascript/loginUser.js"></script>
</body>

</html>