<?php
    require "../utils/sessionStart.php";

    if(isset($_POST[MAP]) && isset($_POST[MOD]) && isset($_POST[OBJ]) && isset($_POST[FILE_NAME]) && isset($_POST[FILE_NAME_PERSO]))
    {
        $map = $_POST[MAP];
        $mod = $_POST[MOD];
        $obj = $_POST[OBJ];
        $fileName = $_POST[FILE_NAME];
        $fileNamePerso = $_POST[FILE_NAME_PERSO];
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "STT001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

    $_SESSION["topText"] = $fileNamePerso." Settings";
	
echo "<!DOCTYPE html>";

echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/stratSettings.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";

        echo "<title>Strat settings</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            include "../UIScripts/TopBar.php";

            echo "<div id=\"stratSettingsBox\">";
                echo "<form id=\"stratNameChangeForm\" name=\"stratNameChange\" action=\"../utils/changeStratSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                    echo "<h3>Strategy Name</h3>";
                    echo "<input type=\"hidden\" name=\"mod\" value=\"stratname\">";
                    echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Name :\" disabled readonly />";
                    echo "<input name=\"stratnameText\" class=\"formTxt\" id=\"stratNameText\" type=\"hidden\" value=\"$fileName\" readonly />";
                    echo "<input name=\"stratnameText\" class=\"formTxt\" id=\"stratNameText\" type=\"text\" value=\"$fileNamePerso\" disabled readonly />";
                    echo "<input name=\"stratnameEdit\" class=\"formEdit\" id=\"stratNameEdit\" type=\"text\" placeholder=\"New name\" required />";
                    echo "<input name=\"submitNewstratName\" class=\"formSubmit\" id=\"submitNewstratName\" type=\"submit\" value=\"Valid\" />";
                echo END_FORM;
            echo END_DIV;
        ?>
    </body>

</html>