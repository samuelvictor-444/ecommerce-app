

       // ✅ Successful login: store session info

        login_user($user['id'], $user['email'], $user['firstName']);

        // reset last activity
        $_SESSION['LAST_ACTIVITY'] = time();



        // $redirect = $_POST['redirect'] ?? 'index.php';
        // // Send success + redirect URL
        // sendSuccess([
        //     "message" => "Login successful ✅",
        //     "redirect" => $_POST['redirect'] ?? 'index.php'
        // ]);
