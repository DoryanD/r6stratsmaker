<?php
    include_once "../classes/Defines.php";
    session_start();
	include_once "../classes/MySqlConnect.php";

    if (isset($_GET[EMAIL], $_GET[CODE]))
    {
        if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?'))
        {
            $stmt->bind_param('ss', $_GET[EMAIL], $_GET[CODE]);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0)
            {
                if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?'))
                {
                    $newcode = 'activated';
                    $stmt->bind_param('sss', $newcode, $_GET[EMAIL], $_GET[CODE]);
                    $stmt->execute();
                    $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "ACT001";
                    $_SESSION[TEXT_MSG] = "Your account is now activated, you can now login";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ACT002";
                $_SESSION[TEXT_MSG] = "The account is already activated or doesn't exist";
                echo TEXT_PAGE_LOCATION;
            }
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ACT001";
        $_SESSION[TEXT_MSG] = "Please re-open the link in your mail box";
        echo TEXT_PAGE_LOCATION;
    }
?>