<?php

    include_once "../classes/Defines.php";

    session_start();

    include_once "../classes/MySqlConnect.php";

    $username = strtolower($_POST[USERNAME_EDIT]);

	if (!isset($username, $_POST[PASSWORD_EDIT]))
	{
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC001";
        $_SESSION[TEXT_MSG] = "Please fill both the username and password field";
        echo TEXT_PAGE_LOCATION;
    }


	if ($stmt = $con->prepare('SELECT id, email, password, activation_code, team_id, user_type FROM accounts WHERE username = ?'))
	{
		$stmt->bind_param('s', $username);
        $stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0)
		{
            $stmt->bind_result($id, $email, $password, $activation_code, $team_id, $user_type);
            $stmt->fetch();
			if (password_verify($_POST[PASSWORD_EDIT], $password))
			{
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = ucwords($username);
                $_SESSION['id'] = $id;
                $_SESSION[EMAIL] = $email;
                $_SESSION['team_id'] = $team_id;
                $_SESSION['user_type'] = $user_type;
                if($user_type != "normalUser")
                {
                    if ($stmt = $con->prepare('SELECT team_name FROM teams WHERE team_id = ?'))
                    {
                        $stmt->bind_param('s', $team_id);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows > 0)
                        {
                            $stmt->bind_result($_SESSION[TEAM_NAME]);
                            $stmt->fetch();
                            if ($activation_code == 'activated')
                            {
                                echo INDEX_PAGE_LOCATION;
                            }
                            else
                            {
                                $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "ATC002";
                                $_SESSION[TEXT_MSG] = "Please use the link send to your mail box : $email, to activate your account";
                                echo TEXT_PAGE_LOCATION;
                            }
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC006";
                            $_SESSION[TEXT_MSG] = "Your team is unknow from the data base";
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC005";
                        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    if ($activation_code == 'activated')
                    {
                        $_SESSION["timestamp"] = time();
                        echo INDEX_PAGE_LOCATION;
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "ATC001";
                        $_SESSION[TEXT_MSG] = "Please use the link send to your mail box : $email, to activate your account";
                        echo TEXT_PAGE_LOCATION;
                    }
                }
			}
			else
			{
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC004";
				$_SESSION[TEXT_MSG] = "Incorrect password";
				echo TEXT_PAGE_LOCATION;
            }
		}
		else
		{
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC003";
			$_SESSION[TEXT_MSG] = "Incorrect username : $username";
			echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "ATC002";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
    
$stmt->close();
?>