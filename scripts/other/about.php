<?php
session_start();

    include_once "../classes/Defines.php";

    $_SESSION["topText"] = "About";

echo "<!DOCTYPE html>";

echo "<html>";

echo "<head>";
echo "<meta charset=\"utf-8\" />";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/about.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";
        
        echo "<title>About</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            include "../UIScripts/TopBar.php";

            echo "<div id=\"aboutBox\">\n";
                echo "<h2>Informations</h2>";
                echo "<ul>\n";
                    echo "<li>Operators icons come from ".MARCOPIXEL_LINK."<br>Licenses : <ul><li>".CC4_LINK."</li></ul>";
                    echo "<li>Map schematics come from ".FUNKYYSMAPS_LINK."</li>";
                    echo "<li>Images on the new strat page and the stratmaker link with Rainbow Six Siege is the property of ".UBISOFT_LINK."</li>";
                    echo "<li>Icons like <i class=\"fas fa-user-cog\"></i> come from ".FONT_AWESOME_LINK."<br>Licenses : <ul><li>".CC4_LINK."</li><li>".SIL_OFL_1_1_LINK."</li><li>".MIT_LICENSE_LINK."</li></li></ul>";
                echo "</ul>\n";
                //echo "<p id=\"infoMsg\">All backgrounds links are available <a href=\"".BG_LINK."\" download>here</a></p>";
                echo "<p class=\"infoMsg centered\">If you have any reclamation, please contact us to solve the problem</p>";
                echo "<p class=\"contact\" class=\"bold\">".CONTACT_TXT_MSG."</p>";
            echo END_DIV;
            

        ?>
    </body>

</html>

