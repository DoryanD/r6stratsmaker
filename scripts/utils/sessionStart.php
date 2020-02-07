<?php

    session_start();
    if (!isset($_SESSION['loggedin'])) {
        echo LOGIN_PAGE_LOCATION;
        exit();
    }

    include_once "../classes/UserClass.php";
    include_once "../classes/TeamClass.php";

    $username = $_SESSION['name'];

    if(file_exists(USERS_PATH.$username.JSON_EXTENSION))
    {
        $userFile = fopen(USERS_PATH.$username.JSON_EXTENSION, "r");
        $jsonStr = "";
        while(!feof($userFile))
        {
            $jsonStr .= fgetc($userFile);
        }
        fclose($userFile);
        $decodedJSON = json_decode($jsonStr);
        $name = $decodedJSON->{'name'};
        $listAccessArray = $decodedJSON->{'fileAccessList'};
        $listAccessArrayPerso = $decodedJSON->{'fileAccessListPerso'};
        $user = new User($name, $listAccessArray, $listAccessArrayPerso);
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SIS001";
        $_SESSION[TEXT_MSG] = "Your personal file doesn't exist in the data base";
        echo TEXT_PAGE_LOCATION;
    }

    if($_SESSION[USER_TYPE] == "teamFounder" || $_SESSION[USER_TYPE] == "teamAdmin" || $_SESSION[USER_TYPE] == "teamMember")
    {
        $team_name = $_SESSION[TEAM_NAME];
        if(file_exists(TEAMS_PATH.$team_name.JSON_EXTENSION))
        {
            $teamFile = fopen(TEAMS_PATH.$team_name.JSON_EXTENSION, "r");
            $jsonStr = "";
            while(!feof($teamFile))
            {
                $jsonStr .= fgetc($teamFile);
            }
            fclose($teamFile);
            $_decodedJSON = json_decode($jsonStr);
            $_teamName = $_decodedJSON->{'teamName'};
            $_founderName = $_decodedJSON->{'founderName'};
            $_members = $_decodedJSON->{'members'};
            $_joinRequest = $_decodedJSON->{'joinRequest'};
            $_stratsShare = $_decodedJSON->{'stratsShare'};
            if($team_name == $_teamName)
            {
                $_TEAM = new Team($_teamName, $_founderName, $_joinRequest, $_stratsShare, $_members);
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SIS003";
                $_SESSION[TEXT_MSG] = "The team name doesn't match in the one in the data base";
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SIS002";
            $_SESSION[TEXT_MSG] = "The team file doesn't exist in the data base";
            echo TEXT_PAGE_LOCATION;
        }
    }

?>