<?php
    require "sessionStart.php";

    if(isset($_POST["toDelete"]))
    {
        $fileToDelete = $_POST["toDelete"];
        $user->removeFromList($fileToDelete);
        if(unlink(STRATS_PATH.$fileToDelete))
        {
            $_SESSION[TEXT_TYPE] = INFO; $_SESSION[TEXT_CODE] = "DLT001";
            $_SESSION[TEXT_MSG] = "The strat " . $fileToDelete . "has been deleted";
            echo TEXT_PAGE_LOCATION;
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DLT002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "DLT001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

?>