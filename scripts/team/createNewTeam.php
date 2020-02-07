<?php

    include_once "../utils/sessionStart.php";
    include_once "../classes/MySqlConnect.php";

    if(isset($_POST[MOD]))
    {
        $mod = $_POST[MOD];
        if(isset($_POST["usernameText"]) && isset($_POST["teamNameEdit"]) && $mod == "createNewTeam")
        {
            $usernameText = $_POST["usernameText"];
            $team_name = $_POST["teamNameEdit"];

            if ($stmt = $con->prepare('SELECT id FROM teams WHERE team_name = ?')) {
                $stmt->bind_param('s', $team_name);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0)
                {
                    $stmt->bind_result($id);
                    $stmt->fetch();

                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT006";
                    $_SESSION[TEXT_MSG] = "This team name is already taken";
                    echo TEXT_PAGE_LOCATION;
                }
                else
                {
                    if ($stmt = $con->prepare('INSERT INTO teams (team_name, founder_name, team_id) VALUES (?, ?, ?)'))
                    {
                        $uniqid = uniqid();
                        $stmt->bind_param('sss', $team_name, $usernameText, $uniqid);
                        $stmt->execute();
                        if(mysqli_query($con, "UPDATE accounts SET user_type='teamFounder', team_id='$uniqid' WHERE username='$usernameText'"))
                        {
                            $team = new Team($team_name, $usernameText, null, null, [$usernameText]);
                            $teamFile = fopen(TEAMS_PATH.$team->getName().JSON_EXTENSION, "w");
                            fwrite($teamFile, $team->getJSON());
                            fclose($teamFile);
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT005";
                            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                            echo TEXT_PAGE_LOCATION;
                        }
                        $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "CNT001";
                        $_SESSION[TEXT_MSG] = "The team " . $team_name . " has been created, please login";
                        echo TEXT_PAGE_LOCATION;
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT004";
                        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                        echo TEXT_PAGE_LOCATION;
                    }
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT003";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNT001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
?>