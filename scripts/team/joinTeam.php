<?php

    session_start();

    include_once "../classes/TeamClass.php";
    include_once "../classes/MySqlConnect.php";

    if(isset($_POST[MOD]))
    {
        $mod = $_POST[MOD];
        if(isset($_POST["usernameText"]) && isset($_POST["teamNameEdit"]) && $mod == "joinTeam")
        {
            $usernameText = $_POST["usernameText"];
            $team_name = $_POST["teamNameEdit"];

            if ($stmt = $con->prepare('SELECT founder_name FROM teams WHERE team_name = ?')) {
                $stmt->bind_param('s', $team_name);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0)
                {
                    $stmt->bind_result($founder_name);
                    $stmt->fetch();
                    if(file_exists(TEAMS_PATH.$team_name.JSON_EXTENSION))
                    {
                        $teamFile = fopen(TEAMS_PATH.$team_name.JSON_EXTENSION, "r");
                        $jsonStr = "";
                        while(!feof($teamFile))
                        {
                            $jsonStr .= fgetc($teamFile);
                        }
                        fclose($teamFile);
                        $decodedJSON = json_decode($jsonStr);
                        $teamName = $decodedJSON->{'teamName'};
                        $founderName = $decodedJSON->{'founderName'};
                        $members = $decodedJSON->{'members'};
                        $joinRequest = $decodedJSON->{'joinRequest'};
                        $stratsShare = $decodedJSON->{'stratsShare'};
                        $team = new Team($teamName, $founderName, $joinRequest, $stratsShare, $members);
                        $team->newJoinRequest($usernameText);
                        $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "JTE001";
                        $_SESSION[TEXT_MSG] = "Request sent";
                        echo TEXT_PAGE_LOCATION;
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE005";
                        $_SESSION[TEXT_MSG] = "Error with the team file";
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE004";
                    $_SESSION[TEXT_MSG] = "The team name is not in the database";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE003";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "JTE001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

?>