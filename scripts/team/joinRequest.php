<?php

    include_once "../utils/sessionStart.php";
    include_once "../classes/TeamClass.php";
    include_once "../classes/MySqlConnect.php";

    if(isset($_POST[MOD]) && isset($_POST[JOIN_USERNAME]))
    {
        $mod = $_POST[MOD];
        $joinUsername = $_POST[JOIN_USERNAME];
        if($mod == "acceptRequest")
        {
            if ($stmt = $con->prepare('SELECT team_id, members FROM teams WHERE team_name = ?'))
            {
                $stmt->bind_param('s', $_SESSION[TEAM_NAME]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0)
                {
                    $stmt->bind_result($team_id, $numMembers);
                    $stmt->fetch();
                    if ($stmt = $con->prepare('SELECT user_type FROM accounts WHERE username = ?'))
                    {
                        $stmt->bind_param('s', $joinUsername);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($joinUserType);
                        $stmt->fetch();
                        if ($joinUserType == "normalUser")
                        {
                            if(mysqli_query($con, "UPDATE accounts SET user_type='teamMember', team_id='$team_id' WHERE username='$joinUsername'"))
                            {
                                $numMembers++;
                                if(mysqli_query($con, "UPDATE teams SET members='$numMembers' WHERE team_id='$team_id'"))
                                {
                                    $_TEAM->addMember($joinUsername);
                                    echo TEAM_SETTINGS_LOCATION;
                                }
                                else
                                {
                                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE008";
                                    $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                                    echo TEXT_PAGE_LOCATION;
                                }
                            }
                            else
                            {
                                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE007";
                                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                                echo TEXT_PAGE_LOCATION;
                            }
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE006";
                            $_SESSION[TEXT_MSG] = "You can't add this user in your team";
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE005";
                        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JRT004";
                    $_SESSION[TEXT_MSG] = INTERNAL_ERROR.$_SESSION[TEAM_NAME];
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JRT003";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        else if($mod == "declineRequest")
        {
            $_TEAM->removeFromList($joinUsername, 0);
            echo TEAM_SETTINGS_LOCATION;
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JRT002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JRT001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
?>