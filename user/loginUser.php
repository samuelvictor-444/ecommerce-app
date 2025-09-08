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
                                <button id="facebook" type="button" class="_log_face">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47062 14 5.5 16 5.5H17.5V2.1401C17.1743 2.09685 15.943 2 14.6429 2C11.9284 2 10 3.65686 10 6.69971V9.5H7V13.5H10V22H14V13.5Z"></path>
                                    </svg>
                                    <span>Log in with Facebook</span>
                                </button>
                            </div>

                            <div class="login_mdc">
                                <button id="Google" type="button" class="_log_face">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                        <g clippath="url(#clip0_1_74)">
                                            <path d="M24.214 12.7245C24.214 11.7413 24.1342 11.0237 23.9616 10.2796H12.7336V14.7176H19.3242C19.1913 15.8205 18.4738 17.4815 16.8793 18.5976L16.8569 18.7461L20.407 21.4963L20.653 21.5209C22.9118 19.4347 24.214 16.3653 24.214 12.7245Z" fill="#4285F4"></path>
                                            <path d="M12.7336 24.4176C15.9624 24.4176 18.673 23.3545 20.653 21.5209L16.8793 18.5976C15.8694 19.3018 14.5141 19.7934 12.7336 19.7934C9.57118 19.7934 6.88712 17.7074 5.93032 14.824L5.79008 14.8359L2.09866 17.6927L2.05038 17.8269C4.01692 21.7334 8.05634 24.4176 12.7336 24.4176Z" fill="#34A853"></path>
                                            <path d="M5.93033 14.824C5.67787 14.0799 5.53176 13.2826 5.53176 12.4588C5.53176 11.6349 5.67787 10.8377 5.91704 10.0936L5.91036 9.93511L2.17268 7.03239L2.05039 7.09056C1.23988 8.71166 0.774815 10.5321 0.774815 12.4588C0.774815 14.3855 1.23988 16.2058 2.05039 17.8269L5.93033 14.824Z" fill="#FBBC05"></path>
                                            <path d="M12.7336 5.12403C14.9791 5.12403 16.4939 6.09402 17.3576 6.90461L20.7326 3.60928C18.6599 1.6826 15.9624 0.5 12.7336 0.5C8.05634 0.5 4.01692 3.18406 2.05038 7.09056L5.91704 10.0936C6.88712 7.2102 9.57118 5.12403 12.7336 5.12403Z" fill="#EB4335"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_74">
                                                <rect width="23.46" height="24" fill="white" transform="translate(0.770004 0.5)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>Login with Google</span>
                                </button>
                            </div>
                        </div>

                        <div class="forgotten_pwd">
                            <button type="button" id="forgot_pwd"">Forgot your password? </button>
                        </div>
                    </div>

                    <div class=" _not_ice">
                                <div>
                                    <p class="_notice">For further support, you may visit the Help Center or contact our customer service team.</p>
                                </div>
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
                                <button id="sms" type="button" class="resend">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f8982d">
                                        <path d="M320-520q17 0 28.5-11.5T360-560q0-17-11.5-28.5T320-600q-17 0-28.5 11.5T280-560q0 17 11.5 28.5T320-520Zm160 0q17 0 28.5-11.5T520-560q0-17-11.5-28.5T480-600q-17 0-28.5 11.5T440-560q0 17 11.5 28.5T480-520Zm160 0q17 0 28.5-11.5T680-560q0-17-11.5-28.5T640-600q-17 0-28.5 11.5T600-560q0 17 11.5 28.5T640-520ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                                    </svg>
                                </button>
                                <p>sms</p>
                            </div>

                            <div class="col_bx_us">
                                <button id="email" type="button" class="secondary">
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
</body>

</html>