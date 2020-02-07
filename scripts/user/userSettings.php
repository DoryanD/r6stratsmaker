<?php
    require "../utils/sessionStart.php";

    $_SESSION["topText"] = $username." Settings";

echo "<!DOCTYPE html>";

echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/userSettings.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";

        echo "<title>User settings</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            include "../UIScripts/TopBar.php";

            echo "<div id=\"userSettingsBox\">";
                echo "<form id=\"usernameChangeForm\" name=\"usernameChange\" action=\"../team/changeUserSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                    echo "<h3>Edit username</h3>";
                    echo "<input type=\"hidden\" name=\"mod\" value=\"username\">";
                    echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Username :\" disabled readonly />";
                    echo "<input name=\"usernameText\" class=\"formTxt\" id=\"usernameText\" type=\"hidden\" value=\"$username\" readonly />\n";
                    echo "<input name=\"usernameText\" class=\"formTxt\" id=\"usernameText\" type=\"text\" value=\"$username\" disabled readonly />";
                    echo "<input name=\"usernameEdit\" class=\"formEdit\" id=\"usernameEdit\" type=\"text\" placeholder=\"New username\" required />";
                    echo "<input name=\"submitNewUsername\" class=\"formSubmit\" id=\"submitNewUsername\" type=\"submit\" value=\"Valid\" />";
                echo END_FORM;

                echo "<form id=\"emailChangeForm\" name=\"emailChange\" action=\"../team/changeUserSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                    echo "<h3>Edit email address</h3>";
                    echo "<input type=\"hidden\" name=\"mod\" value=\"email\">";
                    echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Email :\" disabled readonly />";
                    echo "<input name=\"emailText\" class=\"formTxt\" id=\"emailText\" type=\"hidden\" value=\"".$_SESSION["email"]."\" readonly />";
                    echo "<input name=\"emailText\" class=\"formTxt\" id=\"emailText\" type=\"text\" value=\"".$_SESSION["email"]."\" disabled readonly />";
                    echo "<input name=\"emailEdit\" class=\"formEdit\" id=\"emailEdit\" type=\"email\" placeholder=\"New email\" required />";
                    echo "<input name=\"submitNewEmail\" class=\"formSubmit\" id=\"submitNewEmail\" type=\"submit\" value=\"Valid\" />";
                echo END_FORM;

                echo "<form id=\"passwordChangeForm\" name=\"passwordChange\" action=\"../team/changeUserSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                    echo "<h3>Edit password</h3>";
                    echo "<input type=\"hidden\" name=\"mod\" value=\"password\">";
                    echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Current password :\" disabled readonly />";
                    echo "<input name=\"passwordEdit0\" class=\"formEdit\" id=\"passwordEdit0\" type=\"password\" placeholder=\"Current password\" required />";
                    echo "<input name=\"passwordEdit1\" class=\"formEdit\" id=\"passwordEdit1\" type=\"password\" placeholder=\"New password\" required />";
                    echo "<input name=\"passwordEdit2\" class=\"formEdit\" id=\"passwordEdit2\" type=\"password\" placeholder=\"Confirm new password\" required />";
                    echo "<a href=\"../team/resetPassword.php\" ><input name=\"forgotPassword\" class=\"formForgot\" id=\"forgotPassword\" type=\"button\" value=\"Reset password ?\" readonly /></a>";
                    echo "<input name=\"submitNewpassword\" class=\"formSubmit\" id=\"submitNewPassword\" type=\"submit\" value=\"Valid\" />";
                echo END_FORM;

            echo END_DIV;

            echo "<div onload=\"init()\"></div>";

        ?>
    </body>

</html>