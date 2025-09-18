<?php
require_once "../api/config_session.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usman </title>
    <link rel="stylesheet" href="./css/complete-profile.css">
</head>

<body>

    <div class="container_wrapper">
        <div class="left_container">

            <div class="acc_con">
                <img src="../assets/images/acc_logo.png" alt="">
            </div>

            <h2 id="user_name">Hello samuel Okhoigbe</h2>

            <div class="container_profile">

            </div>

        </div>

        <div class="right_container">
            <h2 id="header_">profile details </h2>

            <form id="user_profile_form">
                <div class="user_form_input">
                    <input type="text" placeholder="First Name" id="first_name" name="userFirstName" class="user_input" autocomplete="true" />
                </div>

                <div class="user_form_input">
                    <input type="text" placeholder="Middle Name" id="middle_name" name="userMiddleName" class="user_input" required />
                </div>

                <div class="user_form_input">
                    <input type="text" placeholder="Last Name" id="last_name" name="userLastName" class="user_input" required />
                </div>


                <div class="user_form_input">
                    <input type="tel" placeholder="Phone" id="user_phone" name="userPhone" class="user_input" required />
                </div>


                <div class="user_form_input">
                    <select name="user_gender" id="user_gender">
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select>
                </div>

                <div class="user_form_input">
                    <input type="date" id="userDOB" name="userDOB" class="user_input" required />
                </div>


                <button id="saveUserDetails" class="btn" type="button">save</button>
            </form>
        </div>


        <div id="successBox" class="messageBox"></div>
    </div>




    <script src="./javascript/complete-userDetails.js"></script>
</body>

</html>