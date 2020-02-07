<?php
    if(isset($_POST[EMAIL_EDIT]) && isset($_POST[USERNAME_EDIT]))
    {
        include_once "../Classes/Defines.php";
        $email = $_POST[EMAIL_EDIT];
        $username = $_POST[USERNAME_EDIT];
    }
    else
    {
        include_once "../utils/sessionStart.php";
        $email = $_SESSION[EMAIL];
    }

    include_once "../classes/MySqlConnect.php";

    if ($stmt = $con->prepare('SELECT recovery_code FROM accounts WHERE username = ?'))
    {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0)
        {
            $stmt->bind_result($recovery_code);
            $stmt->fetch();
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RSP002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RSP001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

        $from = 'noreply@r6stratsmaker.com';
        $subject = 'Account Recovery';
        $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $activate_link = 'http://r6stratsmaker.com/scripts/team/recovery.php?email=' . $email . '&code=' . $recovery_code;
        $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
        mail($email, $subject, $message, $headers);
        
        if(isset($_SESSION["username"]))
        {
            session_destroy();
        }
        $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "RSP001";
        $_SESSION[TEXT_MSG] = "A recovery mail has been sent to your mail box : ".$email;
        echo TEXT_PAGE_LOCATION;

?>