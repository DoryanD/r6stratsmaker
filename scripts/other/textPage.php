<?php
session_start();

    include_once "../classes/Defines.php";

    $txtType = $_SESSION[TEXT_TYPE];
    $txtCode = $_SESSION[TEXT_CODE];
    $txtMsg = $_SESSION[TEXT_MSG];

    $_SESSION["topText"] = $txtType;

    if($txtCode == "CNT001" || $txtCode == "DTT001" || $txtCode == "RSP001"
    || $txtCode == "RCV001" || $txtCode == "CUS001" || $txtCode == "CUS002"
    || $txtCode == "ATC001" || $txtCode == "ATC001"
    )
    {
        $logoutNeeded = true;
    }
    else
    {
        $logoutNeeded = false;
    }

echo "<!DOCTYPE html>";

echo "<html>";

echo "<head>";
echo "<meta charset=\"utf-8\" />";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/textPage.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";
        
        echo "<title>$txtType</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            if($logoutNeeded)
            {

            }
            else
            {
                include "../UIScripts/TopBar.php";
            }

            if($txtType == ERROR)
            {
                echo "<div id=\"errorBox\">";
                    echo "<h2>$txtType</h2>";
                    echo "<h3>Error code : $txtCode</h3>";
                    echo "<p id=\"errorMsg\">$txtMsg</p>";
                    echo "<p id=\"contact\" class=\"bold\">".CONTACT_TXT_MSG."</p>";
                    echo TEXT_REDIRECT;
                echo END_DIV;
            }
            else if($txtType == INFO)
            {
                echo "<div id=\"infoBox\">";
                    echo "<h2>$txtType</h2>";
                    echo "<p id=\"infoMsg\">$txtMsg</p>";
                    if($logoutNeeded)
                    {  echo LOGOUT_REDIRECT; }else{ echo TEXT_REDIRECT; }
                   
                echo END_DIV;
            }

        ?>
    </body>

</html>

