<?php

$otp = random_int(1000, 9999); // generates 1000–9999
$_SESSION["otp"] = $otp;
$_SESSION['otp_user_id'] = $user['id'];
$_SESSION['otp_time'] = time();
