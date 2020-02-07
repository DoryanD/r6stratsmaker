<?php
    include_once "../utils/sessionStart.php";
    include_once "../classes/MapClass.php";

    $_SESSION["topText"] = "New Strat";
	
	$map = $mod = "";
    $roofIndex = 0;

    if(isset($_POST[MAP]) && isset($_POST[MOD]) && isset($_POST[OBJ]) && isset($_POST[FILE_NAME]))
    {
        $map = $_POST[MAP];
        $mod = $_POST[MOD];
        $obj = $_POST[OBJ];
        $fileName = $_POST[FILE_NAME];
    }
    else
    {
        $map = "nomapset";
        $mod = "nomodset";
        $obj = "noobjset";
        $fileName = "nofilenameset";
    }

echo "<!DOCTYPE html>";

echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/img/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/newStrat.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script type=\"text/javascript\" src=\"../js/newStrat.js\"></script>";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";

        echo "<title>New Strategy</title>";
    echo "</head>";

        echo "<body>";

            echo "<img id=\"bg\" src=\"../../UI/img/bg/Originalop.jpg\" />";

            include "../UIScripts/TopBar.php";

            if($map == "nomapset")
            {
                echo "<div id=\"maps\">\n";
                foreach($mapList as &$value)
                {
                    $mapName = $value->getName();
                    if($mapName == "Tower")
                    {
                        echo "<abbr title=\"$mapName\"><img src=\"../../UI/img/maps/$mapName.png\" /></abbr>\n";
                    }
                    else
                    {
                        echo "<abbr title=\"$mapName\"><img id=\"$mapName\" src=\"../../UI/img/maps/$mapName.png\" onmouseenter=\"onMap('$mapName')\" onmouseleave=\"outMap('$mapName')\" onclick=\"addParam('$mapName', '$mod', '$obj', '$fileName')\" /></abbr>\n";
                    }
                }
                echo END_DIV;
            }
            else if($mod == "nomodset")
            {
                echo "<div id=\"mods\">\n";
                    echo "<img id=\"defSelect\" src=\"../../UI/img/other/atkIcoUnselect.png\" />\n";
                    echo "<abbr title=\"Attack\"><img id=\"atkImg\" src=\"../../UI/img/other/atkIco.png\" onmouseenter=\"selectMod('atk')\" onmouseleave=\"unselectMod('atk')\" onclick=\"addParam('$map', 'atk', '$obj', '$fileName')\" /></abbr>\n";
                    echo "<img id=\"atkSelect\" src=\"../../UI/img/other/defIcoUnselect.png\" />\n";
                    echo "<abbr title=\"Defense\"><img id=\"defImg\" src=\"../../UI/img/other/defIco.png\" onmouseenter=\"selectMod('def')\" onmouseleave=\"unselectMod('def')\" onclick=\"addParam('$map', 'def', '$obj', '$fileName')\" /></abbr>\n";
                echo END_DIV;
            }
            else
            {
                echo "<div id=\"objectives\">\n";
                    for($i = 0; $i < sizeof($mapList); $i++)
                    {
                        if($mapList[$i]->getName() == $map)
                        {
                            $objarr = $mapList[$i]->getObjectives();
                            $objFloor = $mapList[$i]->getObjFloor();
                            $roofIndex = $mapList[$i]->getRoofIndex();
                        }
                    }
                    
                    for($i = 0; $i < sizeof($objarr); $i++)
                    {
                        $uniqID = uniqid(date("mdyHis"));
                        echo "<div id=\"nameobj\" onmouseenter=\"actualizeImages($objFloor[$i])\"><div id=\"wordobj\" onclick=\"stratmake('$map', '$mod', '$objarr[$i]', '$uniqID')\">$objarr[$i]</div></div>\n";
                    }
                    
                    for($i = 0; $i <= $roofIndex; $i++)
                    {
                        echo "<img id=\"map$i\" class=\"map\" src=\"../../UI/img/mapsSchematics/$map-$i.png\" />\n";
                    }
                echo END_DIV;
            }

            echo "<form name=\"newStratForm\" action=\"newStrat.php\" method=\"post\" autocomplete=\"off\">\n";
                echo "<input type=\"hidden\" name=\"map\" value=\"nomapset\">";
                echo "<input type=\"hidden\" name=\"mod\" value=\"nomodset\">";
                echo "<input type=\"hidden\" name=\"obj\" value=\"noobjset\">";
                echo "<input type=\"hidden\" name=\"fileName\" value=\"nofilenameset\">";
            echo END_FORM;

            echo "<form name=\"stratmakerForm\" action=\"stratsMaker.php\" method=\"post\" autocomplete=\"off\">\n";
                echo "<input type=\"hidden\" name=\"map\" value=\"nomapset\">";
                echo "<input type=\"hidden\" name=\"mod\" value=\"nomodset\">";
                echo "<input type=\"hidden\" name=\"obj\" value=\"noobjset\">";
                echo "<input type=\"hidden\" name=\"fileName\" value=\"nofilenameset\">";
            echo END_FORM;
            
            function test_input($data)
            {
                return htmlspecialchars(stripslashes(trim($data)));
            }
        ?>

    </body>

</html>