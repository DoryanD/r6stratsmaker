<?php
    include_once "../classes/Defines.php";
	include_once "../classes/MySqlConnect.php";

echo "<!DOCTYPE html>";
echo "<html>";
    echo "<head>";
        echo "<meta charset=\"utf-8\">";
        echo "<title>Login</title>";
        echo "<link href=\"../css/recovery.css\" rel=\"stylesheet\" type=\"text/css\">";
        echo "<link href=\"../css/invisibleA.css\" rel=\"stylesheet\" type=\"text/css\">";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";
    echo "</head>";

    echo "<body>";

    if(isset($_GET[EMAIL]) && isset($_GET[CODE]))
    {
        $postEmail = $_GET[EMAIL];
        $postId = $_GET[CODE];

        if ($stmt = $con->prepare('SELECT recovery_code FROM accounts WHERE email = ?'))
        {
            $stmt->bind_param('s', $postEmail);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($recovery_code);
                $stmt->fetch();
                if($postId == $recovery_code)
                {
                    echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";
                    echo "<div class=\"recovery\">\n";
                        echo "<h1>Account recovery</h1>\n";
                        echo "<form action=\"recovery.php\" method=\"post\" autocomplete=\"off\">\n";
                            echo "<label for=\"username\">\n";
                                echo "<i class=\"ita_user\"></i>\n";
                            echo END_LABEL;
                            echo "<input type=\"text\" name=\"username\" placeholder=\"Username\" id=\"username\" required/>\n";
                            echo "<label for=\"password\">\n";
                                echo "<i class=\"ita_password\"></i>\n";
                            echo END_LABEL;
                            echo "<input type=\"password\" name=\"password\" placeholder=\"New password\" id=\"password\" required/>\n";
                            echo "<input type=\"submit\" value=\"Valid\" />\n";
                            echo "<input type=\"hidden\" name=\"email\" value=\"$postEmail\" />\n";
                        echo END_FORM;
                    echo END_DIV;
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV010";
                    $_SESSION[TEXT_MSG] = "Please re-open the link into your mailbox, after closing this window";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV009";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV008";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else if(isset($_POST[USERNAME]) && isset($_POST[PASSWORD]) && isset($_POST[EMAIL]))
    {
        $username = $_POST[USERNAME];
        $email = $_POST[EMAIL];
        if ($stmt = $con->prepare('SELECT username FROM accounts WHERE email = ?'))
        {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0)
            {
                $stmt->bind_result($SQLusername);
                $stmt->fetch();
                if($username == $SQLusername)
                {
                    $newPassword = password_hash($_POST[PASSWORD], PASSWORD_DEFAULT);
                    if (mysqli_query($con, "UPDATE accounts SET password='$newPassword' WHERE username='$username'"))
                    {
                        $newrecovery_code = uniqid();
                        if(mysqli_query($con, "UPDATE accounts SET recovery_code='$newrecovery_code' WHERE username='$username'"))
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV001";
                            $_SESSION[TEXT_MSG] = "Password has been changed, please login";
                            echo TEXT_PAGE_LOCATION;
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV007";
                            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV006";
                        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV005";
                    $_SESSION[TEXT_MSG] = "It's not your username : $username";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV004";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV003";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "RCV002";
        $_SESSION[TEXT_MSG] = "Please re-open the link into your mailbox, after closing this window";
        echo TEXT_PAGE_LOCATION;
    }

    
?>

    </body>
</html>