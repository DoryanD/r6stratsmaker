<?php

    session_start();

    include_once "../classes/UserClass.php";
    $username = $_SESSION['name'];
    
    if (!isset($_SESSION['loggedin']))
    {
        echo LOGIN_PAGE_LOCATION;
        exit();
    }

    $user = new User($username, null, null);
    $userFile = fopen(USERS_PATH.$user->getName().".json", "w");
    fwrite($userFile, $user->getJSON());
    fclose($userFile);
    if(file_exists(USERS_PATH.$user->getName().".json"))
    {
        echo INDEX_PAGE_LOCATION;
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CNU001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

?>