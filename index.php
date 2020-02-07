<?php

    session_start();

    include_once 'scripts/classes/UserClass.php';
    include_once "scripts/classes/MapClass.php";
    include_once "scripts/classes/FilterClass.php";

    $username = $_SESSION[NAME];
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: scripts/loginSystem/login.php');
        exit();
    }
    
    if(file_exists(substr(SHORT_USERS_PATH, 3).$username.JSON_EXTENSION))
    {
        $userFile = fopen(substr(SHORT_USERS_PATH, 3).$username.JSON_EXTENSION, "r");
        $jsonstr = "";
        while(!feof($userFile))
        {
            $jsonstr .= fgetc($userFile);
        }
        fclose($userFile);
        $decodedJSON = json_decode($jsonstr);
        $name = $decodedJSON->{NAME};
        $listAccessArray = $decodedJSON->{'fileAccessList'};
        $listAccessArrayPerso = $decodedJSON->{'fileAccessListPerso'};
        $user = new User($name, $listAccessArray, $listAccessArrayPerso);
    }
    else
    {
        header('Location: scripts/user/createNewUserFile.php', true, 301);
    }

    $stratsMaps = [];
    $stratsMods = [];
    $stratsObjs = [];

    $mapFilterRule = [];
    $modFilterRule = [];

    for($a = 0; $a < $numberOfMaps; $a++)
    {
        if(isset($_POST["map$a"]))
        {
            array_push($mapFilterRule, $_POST["map$a"]);
        }
    }

    for($b = 0; $b < 2; $b++)
    {
        if(isset($_POST["mod$b"]))
        {
            array_push($modFilterRule, $_POST["mod$b"]);
        }
    }

    if(sizeof($mapFilterRule) < 1)
    {
        $mapFilterRule = ["Bank", "Bartlett", "Border", "Chalet", "Club house", "Coastline", "Consulate", "Favela", "Fortress", "Hereford", "House", "Kafe", "Kanal", "Oregon", "Outback", "Plane", "Skyscraper", "Theme park", "Tower", "Villa", "Yacht"];
    }

    if(sizeof($modFilterRule) < 1)
    {
        $modFilterRule = ["atk", "def"];
    }

    function isIn($strIn, $arrIn)
    {
        for($i = 0; $i < sizeof($arrIn); $i++)
        {
            if($arrIn[$i] == $strIn)
            {
                return true;
            }
        }
    }

echo "<!DOCTYPE html>";

echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"scripts/css/index.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"scripts/css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"scripts/css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"scripts/css/topBar.css\" />";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"scripts/js/index.js\"></script>";

        echo "<title>Home</title>";
    echo "</head>";
        echo "<body>";

            echo "<img id=\"bg\" src=\"UI/img/bg/Originalop.jpg\" />";

            echo "<div id=\"topBar\">\n";
                echo "<p id=\"usernameTB\">".$_SESSION[NAME]."</p>\n";
                //Tempory desactivated//echo "<a id=\"teamSettingsTB\" href=\"scripts/team/teamSettings.php\"><i class=\"fas fa-users-cog\"></i></a>\n";
                echo "<a id=\"userSettingsTB\" href=\"scripts/user/userSettings.php\"><i class=\"fas fa-user-cog\"></i></a>\n";
                echo "<a id=\"logout\" href=\"scripts/loginSystem/logout.php\"><i class=\"fas fa-sign-out-alt\"></i></a>\n";
                echo "<a id=\"about\" href=\"scripts/other/about.php\"><i class=\"fas fa-question-circle\"></i></a>\n";
            echo END_DIV;

            echo "<div id=\"centerBox\">\n";

            echo "<a href=\"scripts/strat/newStrat.php\"><input class=\"newStratTxt\" id=\"newStrat\" type=\"button\" value=\"New Strat\"/></a>\n";
            
            $numberOfStrats = sizeof($listAccessArrayPerso);
            for($i = 0; $i < $numberOfStrats; $i++)
            {
                if(file_exists(substr(SHORT_STRATS_PATH, 3).$listAccessArray[$i]))
                {
                    $stratFile = fopen(substr(SHORT_STRATS_PATH, 3).$listAccessArray[$i], "r");
                    $jsonstr = "";
                    while(!feof($stratFile))
                    {
                        $jsonstr .= fgetc($stratFile);
                    }
                    fclose($stratFile);
                    $decodedJSON = json_decode($jsonstr);
                    $fileName = str_replace(JSON_EXTENSION, "", $listAccessArray[$i]);
                    $fileNamePerso = str_replace(JSON_EXTENSION, "", $listAccessArrayPerso[$i]);
                    $map = $decodedJSON->{MAP};
                    $mod = $decodedJSON->{MOD};
                    $obj = $decodedJSON->{OBJ};
                    array_push($stratsMaps, $map);
                    array_push($stratsMods, $mod);
                    array_push($stratsObjs, $obj);

                    $mapsFiltered = $mapFilter->applyFilter($mapFilterRule, $stratsMaps);
                    $modsFiltered = $mapFilter->applyFilter($modFilterRule, $stratsMods);

                    if(isIn($map, $mapsFiltered) && isIn($mod, $modsFiltered))
                    {
                        echo "<div id=\"stratListBox\">\n";
                            echo "<form name=\"stratListForm\" action=\"scripts/strat/stratsmaker.php\" method=\"post\" autocomplete=\"off\">\n";
                                echo "<input name=\"map\" type=\"hidden\" value=\"".$map.READONLY;
                                echo "<input name=\"mod\" type=\"hidden\" value=\"".$mod.READONLY;
                                echo "<input name=\"obj\" type=\"hidden\" value=\"".$obj.READONLY;
                                echo "<input name=\"fileName\" type=\"hidden\" value=\"$fileName\" readonly />\n";
                                echo "<input name=\"fileNameSbm\" class=\"fileNameTxt\" type=\"submit\" value=\"$fileNamePerso\" readonly />\n";
                                echo "<i name=\"stratSettings\" class=\"fas fa-cog\" id=\"stratsSettingsBtn\" onclick=\"goto(0, '$i')\"></i>\n";
                                echo "<i name=\"stratDelete\" class=\"fas fa-trash-alt\" id=\"stratsDeleteBtn\" onclick=\"goto(1, '$i')\"></i>\n";
                            echo END_FORM;
                        echo END_DIV;
                        echo "<form name=\"stratSettingsForm$i\" action=\"scripts/strat/stratSettings.php\" method=\"post\" autocomplete=\"off\">\n";
                            echo "<input name=\"map\" type=\"hidden\" value=\"".$map.READONLY;
                            echo "<input name=\"mod\" type=\"hidden\" value=\"".$mod.READONLY;
                            echo "<input name=\"obj\" type=\"hidden\" value=\"".$obj.READONLY;
                            echo "<input name=\"fileName\" type=\"hidden\" value=\"$fileName\" readonly />\n";
                            echo "<input name=\"fileNamePerso\" type=\"hidden\" value=\"$fileNamePerso\" readonly />\n";
                        echo END_FORM;
                        echo "<form name=\"stratDeleteForm$i\" action=\"scripts/utils/deleteStrat.php\" method=\"post\" autocomplete=\"off\">\n";
                            echo "<input name=\"toDelete\" type=\"hidden\" value=\"".$fileName.".json\" readonly />\n";
                        echo END_FORM;
                    }
                }
                else
                {
                    $_SESSION[ERROR_CODE] = "IND001";
                    $_SESSION[ERROR_MSG] = "The file you're trying to load doesn't exist in the database";
                    echo "<script type='text/javascript'>document.location.replace(".LOCATION_ERRP.");</script>";
                }
            }
            echo END_DIV;

            echo "<div id=\"filterListBox\">\n";
                echo "<h2>Filters</h2>\n";
                echo "<form name=\"filterListForm\" id=\"filterListForm\" action=\"index.php\" method=\"post\" autocomplete=\"off\">\n";
                    echo "<h3>Map</h3>\n";
                        for($k = 0; $k < $numberOfMaps; $k++)
                        {
                            $checked = isIn($mapList[$k]->getName(), $mapFilterRule) ? "checked" : "";
                            echo "<label class=\"filteredContainer\">".$mapList[$k]->getName()." : <input name=\"map$k\" type=\"checkbox\" value=\"".$mapList[$k]->getName()."\" ".$checked."/><span class=\"checkmark\"></span></label>\n";
                        }
                    echo "<h3>Mod</h3>\n";
                        $checked = isIn("atk", $modFilterRule) ? "checked" : "";
                        echo "<label class=\"filteredContainer\">Attack : <input name=\"mod0\" type=\"checkbox\" value=\"atk\" ".$checked."/><span class=\"checkmark\"></span></label>\n";
                        $checked = isIn("def", $modFilterRule) ? "checked" : "";
                        echo "<label class=\"filteredContainer\">Defense : <input name=\"mod1\" type=\"checkbox\" value=\"def\" ".$checked."/><span class=\"checkmark\"></span></label>\n";

                    echo "<input name=\"filterListFormSubmit\" id=\"filterListFormSubmit\" type=\"submit\" value=\"Apply filters\" />\n";
                echo END_FORM;
            echo END_DIV;
            
        ?>
    </body>

</html>