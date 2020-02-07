<?php

    include_once "../utils/sessionStart.php";
    include_once "../classes/MySqlConnect.php";

    if(isset($_POST[MOD]))
    {
        $mod = $_POST[MOD];
        if($mod == "deleteTeam")
        {
            if($_SESSION[USER_TYPE] == "teamFounder")
            {
                if ($stmt = $con->prepare('SELECT team_id FROM teams WHERE team_name = ?')) {
                    $stmt->bind_param('s', $_teamName);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows > 0)
                    {
                        $stmt->bind_result($team_id);
                        $stmt->fetch();
                        if ($stmt = $con->prepare('DELETE FROM teams WHERE team_name = ? ')) {
                            $stmt->bind_param('s', $_teamName);
                            $stmt->execute();
                            $stmt->store_result();
                            if(mysqli_query($con, "UPDATE accounts SET user_type='normalUser' WHERE team_id='$team_id'"))
                            {
                                if(unlink(TEAMS_PATH.$_teamName.JSON_EXTENSION))
                                {
                                    if(mysqli_query($con, "UPDATE accounts SET team_id='NONE' WHERE user_type='normalUser'"))
                                    {
                                        $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "DTT001";
                                        $_SESSION[TEXT_MSG] = "The team " . $_teamName . " has been deleted";
                                        echo TEXT_PAGE_LOCATION;
                                    }
                                    else
                                    {
                                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT008";
                                        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                                        echo TEXT_PAGE_LOCATION;
                                    }
                                }
                                else
                                {
                                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT007";
                                    $_SESSION[TEXT_MSG] = "Can't find the team file";
                                    echo TEXT_PAGE_LOCATION;
                                }
                            }
                            else
                            {
                                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT006";
                                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                                echo TEXT_PAGE_LOCATION;
                            }
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT005";
                            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT004";
                        $_SESSION[TEXT_MSG] = "The team " . $_teamName . " doesn't exist";
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT003";
                    $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT002";
                $_SESSION[TEXT_MSG] = "You don't have this permission on the team";
                echo TEXT_PAGE_LOCATION;
            }
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DTT001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

?>