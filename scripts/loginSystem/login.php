<?php
    include_once "../classes/Defines.php";

    if(isset($_GET["mod"]))
    {
        $mod = $_GET["mod"];
    }
    else
    {
        $mod = 0;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link href="../css/login.css" rel="stylesheet" type="text/css">
        <link href="../css/invisibleA.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/627dc89a4b.js"></script>
        <script type="text/javascript" src="../js/formInfo.js"></script>
        </head>
    
    <body>

        <?php

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            echo "<div id=\"logBox\">\n";
                if($mod == 0)
                {
                    echo "<form name=\"loginForm\" action=\"authenticate.php\" method=\"post\" autocomplete=\"off\" >\n";
                        echo "<h3>Login</h3>";
                        echo "<span id=\"usernameBox\">";
                            echo LABEL_USERNAME_LOGIN;
                            echo INPUT_USERNAME_LOGIN;
                        echo END_SPAN;
                        echo "<span id=\"passwordBox\">";
                            echo LABEL_PASSWORD_LOGIN;
                            echo INPUT_PASSWORD_LOGIN;
                        echo END_SPAN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Login\" />\n";
                            echo INPUT_FORGOT_PASSWORD_LOGIN;
                            echo "<a href=\"login.php?mod=1\" ><input name=\"createAccount\" class=\"formCreate\" id=\"createAccount\" type=\"button\" value=\"Register\" readonly /></a>\n";
                        echo END_DIV;
                    echo END_FORM;
                }
                else if($mod == 1)
                {
                    echo "<form name=\"registerForm\" action=\"register.php\" method=\"post\" autocomplete=\"off\">\n";
                        echo "<h3>Register</h3>";
                        echo "<span id=\"usernameBox\">";
                            echo LABEL_USERNAME_LOGIN;
                            echo INPUT_USERNAME_LOGIN_PATTERN;
                        echo END_SPAN;
                        echo "<span id=\"passwordBox\">";
                            echo LABEL_PASSWORD_LOGIN;
                            echo INPUT_PASSWORD_LOGIN_PATTERN;
                        echo END_SPAN;
                        echo "<span id=\"emailBox\">";
                            echo LABEL_EMAIL_LOGIN;
                            echo INPUT_EMAIL_LOGIN_PATTERN;
                        echo END_SPAN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Register\" />\n";
                            echo INPUT_FORGOT_PASSWORD_LOGIN;
                            echo INPUT_SUBMIT_LOGIN;
                        echo END_DIV;
                    echo END_FORM;
                }
                else if($mod == 2)
                {
                    echo "<form name=\"registerForm\" action=\"../user/resetPassword.php\" method=\"post\" autocomplete=\"off\" >\n";
                        echo "<h3>Account Recovery</h3>";
                        echo "<span id=\"usernameBox\">";
                            echo LABEL_USERNAME_LOGIN;
                            echo INPUT_USERNAME_LOGIN;
                        echo END_SPAN;
                        echo "<span id=\"emailBox\">";
                            echo LABEL_EMAIL_LOGIN;
                            echo INPUT_EMAIL_LOGIN;
                        echo END_SPAN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Send\" />\n";
                            echo INPUT_SUBMIT_LOGIN;
                        echo END_DIV;
                    echo END_FORM;
                }
            echo END_DIV;
        ?>
    </body>
</html>

<!-- 

<?php/*
    include_once "../classes/Defines.php";

    if(isset($_GET["mod"]))
    {
        $mod = $_GET["mod"];
    }
    else
    {
        $mod = 0;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link href="../css/login.css" rel="stylesheet" type="text/css">
        <link href="../css/invisibleA.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/627dc89a4b.js"></script>
        <script type="text/javascript" src="../js/formInfo.js"></script>
        </head>
    
    <body>

        <?php/*

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            echo "<div id=\"logBox\">\n";
                if($mod == 0)
                {
                    echo "<form name=\"loginForm\" action=\"authenticate.php\" method=\"post\" autocomplete=\"off\" >\n";
                        echo "<h3>Login</h3>";
                        echo LABEL_USERNAME_LOGIN;
                        echo INPUT_USERNAME_LOGIN;
                        echo LABEL_PASSWORD_LOGIN;
                        echo INPUT_PASSWORD_LOGIN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Login\" />\n";
                            echo INPUT_FORGOT_PASSWORD_LOGIN;
                            echo "<a href=\"login.php?mod=1\" ><input name=\"createAccount\" class=\"formCreate\" id=\"createAccount\" type=\"button\" value=\"Register\" readonly /></a>\n";
                        echo END_DIV;
                    echo END_FORM;
                }
                else if($mod == 1)
                {
                    echo "<form name=\"registerForm\" action=\"register.php\" method=\"post\" autocomplete=\"off\">\n";
                        echo "<h3>Register</h3>";
                        echo LABEL_USERNAME_LOGIN;
                        echo INPUT_USERNAME_LOGIN_PATTERN;
                        echo LABEL_PASSWORD_LOGIN;
                        echo INPUT_PASSWORD_LOGIN_PATTERN."<br>";
                        echo LABEL_EMAIL_LOGIN;
                        echo INPUT_EMAIL_LOGIN_PATTERN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Register\" />\n";
                            echo INPUT_FORGOT_PASSWORD_LOGIN;
                            echo INPUT_SUBMIT_LOGIN;
                        echo END_DIV;
                    echo END_FORM;
                }
                else if($mod == 2)
                {
                    echo "<form name=\"registerForm\" action=\"../user/resetPassword.php\" method=\"post\" autocomplete=\"off\" >\n";
                        echo "<h3>Account Recovery</h3>";
                        echo LABEL_USERNAME_LOGIN;
                        echo INPUT_USERNAME_LOGIN;
                        echo LABEL_EMAIL_LOGIN;
                        echo INPUT_EMAIL_LOGIN;
                        echo BOTTOM_BOX;
                            echo "<input name=\"submitLogin\" class=\"formSubmit\" id=\"submitLogin\" type=\"submit\" value=\"Send\" />\n";
                            echo INPUT_SUBMIT_LOGIN;
                        echo END_DIV;
                    echo END_FORM;
                }
            echo END_DIV;
        ?>
    </body>
</html>

-->