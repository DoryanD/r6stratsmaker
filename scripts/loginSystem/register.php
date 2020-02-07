<?php
    include_once "../classes/Defines.php";
    session_start();
    include_once "../classes/MySqlConnect.php";

    $username = strtolower($_POST[USERNAME_EDIT]);

    if (
    (!isset($username, $_POST[PASSWORD_EDIT], $_POST[EMAIL_EDIT]))
    ||
    (empty($username) || empty($_POST[PASSWORD_EDIT]) || empty($email))
    )
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG002";
        $_SESSION[TEXT_MSG] = "Please complete the registration form";
        echo TEXT_PAGE_LOCATION;
    }

    $email = $_POST[EMAIL_EDIT];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG003";
        $_SESSION[TEXT_MSG] = "The email isn't valid";
        echo TEXT_PAGE_LOCATION;
    }

    $username = str_replace(" ", "_", $username);
    preg_match_all(REGEX_FILTER, $username, $matches);
    $username = "";
    foreach($matches[0] as $str)
    {
        $username .= $str;
    }

    if (strlen($_POST[PASSWORD_EDIT]) > 20 || strlen($_POST[PASSWORD_EDIT]) < 5)
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG004";
        $_SESSION[TEXT_MSG] = "Password must be between 5 and 20 characters long";
        echo TEXT_PAGE_LOCATION;
    }

    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?'))
    {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0)
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG005";
            $_SESSION[TEXT_MSG] = "This username is already taken, please choose another";
            echo TEXT_PAGE_LOCATION;
        }
        else if($stmt = $con->prepare('SELECT id, password FROM accounts WHERE email = ?'))
        {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0)
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG006";
                $_SESSION[TEXT_MSG] = "This email is already taken, please choose another";
                echo TEXT_PAGE_LOCATION;
            }
            else
            {

                if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code, recovery_code) VALUES (?, ?, ?, ?, ?)'))
                {
                    $password = password_hash($_POST[PASSWORD_EDIT], PASSWORD_DEFAULT);
                    $uniqid = uniqid();
                    $uniqid2 = uniqid();
                    $stmt->bind_param('sssss', $username, $password, $email, $uniqid, $uniqid2);
                    $stmt->execute();
                    $from = 'noreply@r6stratsmaker.com';
                    $subject = 'Account Activation Required';
                    $headers = 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion()."\r\n".'MIME-Version: 1.0'."\r\n".'Content-Type: text/html; charset=UTF-8'."\r\n";
                    $activate_link = 'http://r6stratsmaker.com/scripts/loginSystem/activate.php?email='.$email.'&code='.$uniqid;
                    $message = '<p>Please click the following link to activate your account: <a href="'.$activate_link.'">'.$activate_link.'</a></p>';
                    mail($email, $subject, $message, $headers);
                    
                    $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "REG001";
                    $_SESSION[TEXT_MSG] = "Please check your email to activate your account";
                    echo TEXT_PAGE_LOCATION;
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG007";
                    $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                    echo TEXT_PAGE_LOCATION;
                }
            }
        }
        $stmt->close();
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "REG008";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
    $con->close();
?>