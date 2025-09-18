<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="./css/styles.css">
    <script src="../assets/javascript/jquery.js"></script>
     <script src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
                                <div class="visible_togg">

                                    <svg class="not_v" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#313131">
                                        <path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z" />
                                    </svg>

                                    <svg class="show_pwd" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#313131">
                                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                    </svg>

                                </div>
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
                                <a href="./signUpUser.php?redirect=<?php echo htmlspecialchars($_GET['redirect'] ?? 'index.php');  ?>">Create an Account</a>
                            </div>

                            <div class="login_mdc">
                                <button id="facebook" type="button" class="_log_face">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47062 14 5.5 16 5.5H17.5V2.1401C17.1743 2.09685 15.943 2 14.6429 2C11.9284 2 10 3.65686 10 6.69971V9.5H7V13.5H10V22H14V13.5Z"></path>
                                    </svg>
                                    <span>Log in with Facebook</span>
                                </button>
                            </div>

                            <div class="login_mdc">
                                <!-- Google Sign-In button -->
                                <div id="g_id_onload"
                                    data-client_id="1006726004609-t3lqnhbig902h5kschcde6kkp8ep7oj0.apps.googleusercontent.com"
                                    data-callback="handleCredentialResponse"
                                    data-auto_prompt="false">
                                </div>

                                <div class="g_id_signin"
                                    data-type="standard"
                                    data-shape="rectangular"
                                    data-theme="outline"
                                    data-text="signin_with"
                                    data-size="large"
                                    data-logo_alignment="left">
                                </div>
                            </div>

                           

                        </div>

                        <div class="forgotten_pwd">
                            <button type="button" id="forgot_pwd">Forgot your password? </button>
                        </div>

                    </div>

                    <!-- <div class=" _not_ice">
                                <div>
                                    <p class="_notice">For further support, you may visit the Help Center or contact our customer service team.</p>
                                </div>
                        </div> -->


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
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? '../index.php'); ?>">

                        <div id="email_input" class="otp_verify_n">
                            <div class="identifiyer_d">
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    maxlength="1"
                                    name="otp[]"
                                    class="input_user opt_input"
                                    required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" type="text" name="otp[]" class="input_user opt_input" required>
                            </div>
                            <div class="identifiyer_d">
                                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" type="text" name="otp[]" class="input_user opt_input" required>
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

                        <div class="disclaimer" id="colx">
                            <label id="new_code">Request a new code in</label>
                        </div>

                        <div class="container_resend">

                            <div class="col_bx_us">
                                <button id="resend_sms_email" type="button" class="resend">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f8982d">
                                        <path d="M320-520q17 0 28.5-11.5T360-560q0-17-11.5-28.5T320-600q-17 0-28.5 11.5T280-560q0 17 11.5 28.5T320-520Zm160 0q17 0 28.5-11.5T520-560q0-17-11.5-28.5T480-600q-17 0-28.5 11.5T440-560q0 17 11.5 28.5T480-520Zm160 0q17 0 28.5-11.5T680-560q0-17-11.5-28.5T640-600q-17 0-28.5 11.5T600-560q0 17 11.5 28.5T640-520ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                                    </svg>
                                </button>
                                <p>sms</p>
                            </div>

                            <div class="col_bx_us">
                                <button id="resend_otp_email" type="button" class="secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f8982d">
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

                </div>
            </form>
        </div>
    </div>

    <!------------------------------- HERE ENDS THE SIGN IN CONTAINER WRAPPER  -------------------------->
    <script src="./javascript/loginUser.js"></script>
    <script src="./javascript/resend_userOtp.js"></script>
    <script src="./javascript/loginGoogle.js"></script>
    <script src="./javascript/loginFacebook.js"></script>
    <script>
        document.querySelector("#forgot_pwd").addEventListener("click" , () => {
            const userEmail =document.querySelector("#hiddenEmail").value.trim();

            if(!userEmail) {
                console.error("user email not found");
                return;
            } 


            const redirect = new URLSearchParams(window.location.search).get("redirect");

             window.location.href = `./password_reset.php?redirect=${redirect || "index.php"}&userEmail=${userEmail}`;
        });
    </script>
</body>

</html>