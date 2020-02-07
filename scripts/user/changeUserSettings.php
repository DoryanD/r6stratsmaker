<?php
    include_once "../utils/sessionStart.php";
	include_once "../classes/MySqlConnect.php";

    if(isset($_POST[MOD]))
    {
        $mod = strtolower($_POST[MOD]);
        if($mod !== "password")
        {
            $oldValue = $_POST[$mod."Text"];
            if($mod == "username")
            {
                $newValue = ucwords($_POST[$mod."Edit"]);
            }
            else
            {
                $newValue = $_POST[$mod."Edit"];
            }
            
        }
        else
        {
            $oldValue = $_POST["passwordEdit0"];
            $newValue = $_POST["passwordEdit1"];
            $confirmNewValue = $_POST["passwordEdit2"];
            if ($stmt = $con->prepare('SELECT password FROM accounts WHERE username = ?'))
            {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0)
                {
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    if(password_verify($oldValue, $password))
                    {
                        if($confirmNewValue == $newValue)
                        {
                            if(strlen($newValue) > 5 && strlen($newValue) < 20)
                            {
                                $oldValue = $password;
                                $newValue = password_hash($newValue, PASSWORD_DEFAULT);
                            }
                            else
                            {
                                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS008";
                                $_SESSION[TEXT_MSG] = "Password must be between 5 and 20 characters long";
                                echo TEXT_PAGE_LOCATION;
                            }
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS007";
                            $_SESSION[TEXT_MSG] = "Both new passwords don't match";
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS006";
                        $_SESSION[TEXT_MSG] = "Wrong password";
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS005";
                    $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS004";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }

        if($username != $newValue)
        {
            if (mysqli_query($con, "UPDATE accounts SET $mod='$newValue' WHERE $mod='$oldValue'"))
            {
                if($mod !== "password")
                {
                    if($mod == "username")
                    {
                        $user->rename($oldValue, $newValue);
                    }
                    $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "CUS002";
                    $_SESSION[TEXT_MSG] = "Your older $mod : $oldValue, has been modifed to $newValue<br>Please sign in";
                    echo TEXT_PAGE_LOCATION;
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "CUS001";
                    $_SESSION[TEXT_MSG] = "Your password has been modified<br>Please sign in";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS003";
                $_SESSION[TEXT_MSG] = "This $mod is already taken";
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS002";
            $_SESSION[TEXT_MSG] = "It's already you're username";
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CUS001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
    $con->close();
?>