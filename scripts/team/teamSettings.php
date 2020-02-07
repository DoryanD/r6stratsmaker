<?php
    require "../utils/sessionStart.php";

    $_SESSION["topText"] = "Team Settings";

echo "<!DOCTYPE html>";

echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/teamSettings.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";

        echo "<title>Team settings</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            include "../UIScripts/TopBar.php";

            echo "<div id=\"teamSettingsBox1\">";

                if($_SESSION[USER_TYPE] == "normalUser")
                {
                    echo "<form id=\"createNewTeamForm\" name=\"createNewTeam\" action=\"createNewTeam.php\" method=\"post\" autocomplete=\"off\">\n";
                        echo "<h3>Create a team</h3>";
                        echo "<input type=\"hidden\" name=\"mod\" value=\"createNewTeam\">";
                        echo "<input name=\"usernameText\" class=\"formTxt\" id=\"usernameText\" type=\"hidden\" value=\"$username\" readonly />\n";
                        echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Team name :\" disabled readonly />";
                        echo "<input name=\"teamNameEdit\" class=\"formEdit\" id=\"teamNameEdit\" type=\"text\" placeholder=\"Enter de exact team name\" required />";
                        echo "<input name=\"submitCreateNewTeam\" class=\"formSubmit\" id=\"submitCreateNewTeam\" type=\"submit\" value=\"Create\" />";
                    echo END_FORM;

                    echo "<form id=\"joinTeamForm\" name=\"joinTeam\" action=\"joinTeam.php\" method=\"post\" autocomplete=\"off\">\n";
                        echo "<h3>Join a team</h3>";
                        echo "<input type=\"hidden\" name=\"mod\" value=\"joinTeam\">";
                        echo "<input name=\"usernameText\" class=\"formTxt\" id=\"usernameText\" type=\"hidden\" value=\"$username\" readonly />\n";
                        echo "<input name=\"preText\" class=\"formPreTxt\" type=\"text\" value=\"Team name :\" disabled readonly />";
                        echo "<input name=\"teamNameEdit\" class=\"formEdit\" id=\"teamNameEdit\" type=\"text\" placeholder=\"Enter de exact team name\" required />";
                        echo "<input name=\"submitJoinTeam\" class=\"formSubmit\" id=\"submitJoinTeam\" type=\"submit\" value=\"Send request\" />";
                    echo END_FORM;
                }

            echo END_DIV;

            
            if($_SESSION[USER_TYPE] == "teamFounder" || $_SESSION[USER_TYPE] == "teamAdmin")
            {
                echo "<div id=\"teamSettingsBox2\">";
                    echo "<h3>Join Requests</h3>";
                    if(sizeof($_joinRequest) > 0)
                    {
                        for($i = 0; $i < sizeof($_joinRequest); $i++)
                        {
                            echo "<form id=\"joinRequestForm\" name=\"joinRequest\" action=\"joinRequest.php\" method=\"post\" autocomplete=\"off\">\n";
                                echo "<input type=\"hidden\" name=\"mod\" value=\"acceptRequest\">";
                                echo "<input type=\"text\" name=\"joinUsername\" class=\"formTxt\" id=\"joinUsernameText\" value=\"$_joinRequest[$i]\" disable required/>\n";
                                echo "<input name=\"submitJoinRequest\" class=\"formSubmit\" id=\"submitJoinRequest\" type=\"submit\" value=\"Accept\" />";
                            echo END_FORM;
                            echo "<form id=\"joinRequestForm\" name=\"joinRequest\" action=\"joinRequest.php\" method=\"post\" autocomplete=\"off\">\n";
                                echo "<input type=\"hidden\" name=\"mod\" value=\"declineRequest\">";
                                echo "<input type=\"hidden\" name=\"joinUsername\" class=\"formTxt\" id=\"joinUsernameText\" value=\"$_joinRequest[$i]\" disable required/>\n";
                                echo "<input name=\"submitJoinRequest\" class=\"formSubmit\" id=\"submitJoinRequest\" type=\"submit\" value=\"Decline\" />";
                            echo END_FORM;
                        }
                    }
                echo END_DIV;
                echo "<div id=\"teamSettingsBox3\">";
                    echo "<h3>Members</h3>";
                    for($i = 0; $i < sizeof($_members); $i++)
                    {
                        echo "<form id=\"teamMembersForm\" name=\"teamMembers\" action=\"teamMemberSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                            echo "<input type=\"hidden\" name=\"mod\" value=\"showMember\">";
                            echo "<input type=\"hidden\" name=\"member\" class=\"formTxt\" id=\"joinUsernameText\" value=\"$_members[$i]\" disable required/>\n";
                            echo "<input name=\"submitTeamMember\" class=\"formSubmit\" id=\"submitTeamMember\" type=\"submit\" value=\"$_members[$i]\" />";
                        echo END_FORM;
                    }
                echo END_DIV;
                echo "<div id=\"teamSettingsBox4\">";
                    echo "<h3>Team Strats</h3>";
                    for($i = 0; $i < sizeof($_stratsShare); $i++)
                    {
                        echo "<form id=\"teamStratsForm\" name=\"teamStrats\" action=\"teamStratsSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                            echo "<input type=\"hidden\" name=\"mod\" value=\"showStrat\">";
                            echo "<input type=\"hidden\" name=\"member\" class=\"formTxt\" id=\"joinUsernameText\" value=\"$_stratsShare[$i]\" disable required/>\n";
                            echo "<input name=\"teamStrats\" class=\"formSubmit\" id=\"teamStrats\" type=\"submit\" value=\"\" />";
                        echo END_FORM;
                    }
                echo END_DIV;
            }
            
            if($_SESSION[USER_TYPE] == "teamFounder")
            {
                echo "<div id=\"teamSettingsBox5\">";
                    echo "<form id=\"deleteTeamForm\" name=\"deleteTeam\" action=\"deleteTeam.php\" method=\"post\" autocomplete=\"off\">\n";
                        echo "<h3>Delete $_teamName</h3>";
                        echo "<input type=\"hidden\" name=\"mod\" value=\"deleteTeam\">";
                        echo "<input name=\"submitDeleteTeam\" class=\"formSubmit\" id=\"submitDeleteTeam\" type=\"submit\" value=\"Delete\" />";
                    echo END_FORM;
                echo END_DIV;
            }

            echo "<div onload=\"init()\"></div>";

        ?>
    </body>

</html>