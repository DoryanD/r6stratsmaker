<?php

    echo "<header id=\"topBar\">\n";
        echo "<a id=\"home\" href=\"../../index.php\"><i class=\"fas fa-home\"></i></a>\n";
        echo "<p id=\"usernameTB\">".$_SESSION["topText"]."</p>\n";
        //Tempory desactivated//echo "<a id=\"teamSettingsTB\" href=\"../team/teamSettings.php\"><i class=\"fas fa-users-cog\"></i></a>\n";
        echo "<a id=\"userSettingsTB\" href=\"../user/userSettings.php\"><i class=\"fas fa-user-cog\"></i></a>\n";
        echo "<a id=\"logout\" href=\"../loginSystem/logout.php\"><i class=\"fas fa-sign-out-alt\"></i></a>\n";
        echo "<a id=\"about\" href=\"../other/about.php\"><i class=\"fas fa-question-circle\"></i></a>\n";
    echo END_HEADER;

?>