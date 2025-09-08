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
                            <button id="Continue" type="button" class="cont_btn disabled">Continue</button>
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
                        <img src="../assets/images/icon2.png" alt="" width="24px">
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
                                <input maxlength="1" type="number" min="0" max="9" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="number" min="0" max="9" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="number" min="0" max="9" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" type="number" min="0" max="9" name="otp[]" class="input_user opt_input" required>
                            </div>
                        </div>

                        <p id="otp_error_msg"></p>
                    </div>



                    <div class="controls">
                        <div class="btn_contrl">
                            <button id="verify_opt" type="button" class="cont_btn">verify opt</button>
                        </div>

                        <div class="count_down">

                        </div>

                        <div class="disclaimer">
                            <label id="new_code">Request a new code in</label>
                        </div>

                        <div class="container_resend">

                            <div class="col_bx_us">
                                <button id="sms" type="button" class="resend">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                        <path d="M320-520q17 0 28.5-11.5T360-560q0-17-11.5-28.5T320-600q-17 0-28.5 11.5T280-560q0 17 11.5 28.5T320-520Zm160 0q17 0 28.5-11.5T520-560q0-17-11.5-28.5T480-600q-17 0-28.5 11.5T440-560q0 17 11.5 28.5T480-520Zm160 0q17 0 28.5-11.5T680-560q0-17-11.5-28.5T640-600q-17 0-28.5 11.5T600-560q0 17 11.5 28.5T640-520ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                                    </svg>
                                </button>
                                <p>sms</p>
                            </div>

                            <div class="col_bx_us">
                                <button id="email" type="button" class="secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                                    </svg>
                                </button>
                                <p>email</p>
                            </div>
                        </div>



                    </div>

                    <div class="_not_ice">
                        <div>
                            <p class="_notice">For further support, you may visit the Help Center or contact our customer service team.</p>
                        </div>
                    </div>


                    <div class="log_bott">
                        <img src="../assets/images/icon2.png" alt="" width="24px">
                    </div>





                </div>
            </form>
        </div>
    </div>

    <!------------------------------- HERE ENDS THE SIGN IN CONTAINER WRAPPER  -------------------------->
    <script src="./javascript/loginUser.js"></script>
</body>

</html>