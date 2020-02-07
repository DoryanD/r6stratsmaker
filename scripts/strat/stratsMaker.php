<?php
    include_once "../utils/sessionStart.php";
    include_once "../classes/MapClass.php";

    $_SESSION["topText"] = "Strat maker";

echo "<!DOCTYPE html>";
echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
        echo "<link rel=\"icon\" type=\"image/ico\" href=\"../../UI/r6.ico\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/stratsMaker.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/loadingScript.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleScrollbar.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/invisibleA.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/topBar.css\" />";
        echo "<script type=\"text/javascript\" src=\"../js/stratsMaker.js\"></script>";
        echo "<script src=\"https://kit.fontawesome.com/627dc89a4b.js\"></script>";

        
        echo "<title>Stratmaker</title>";
    echo "</head>";
    
        if(isset($_POST[MAP]) && isset($_POST[MOD]) && isset($_POST[OBJ]) && isset($_POST[FILE_NAME]))
        {
            $map = $_POST[MAP];
            $mod = $_POST[MOD];
            $obj = $_POST[OBJ];
            $fileName = $_POST[FILE_NAME].JSON_EXTENSION;
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SMK001";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }

        if(isset($_POST[JSON_TXT]))
        {
            $jsontxt = $_POST[JSON_TXT];
        }
        else
        {
            $jsontxt = "none";
        }

        $opnames = ["Smoke", "Mute", "Castle", "Pulse", "Doc", "Rook", "Kapkan", "Tachanka", "Jager", "Bandit", "Frost", "Valkyrie", "Caveira", "Echo", "Mira", "Lesion", "Ela", "Vigil", "Maestro", "Alibi", "Clash", "Kaid", "Mozzie", "Warden", "Goyo", "Sledge", "Thatcher", "Ash", "Thermite", "Twitch", "Montagne", "Glaz", "Fuze", "Blitz", "IQ", "Buck", "Blackbeard", "Capitao", "Hibana", "Jackal", "Ying", "Zofia", "Dokkaebi", "Lion", "Finka", "Maverick", "Nomad", "Gridlock", "Nokk", "Amaru"];
        $gadgetsnames = ["Barbed wire", "Bulletproof camera", "C4", "Impact grenade", "Shield", "Breach charge", "Claymore", "Flash grenade", "Frag grenade", "Smoke grenade"];
        $abilitienames1 = ["Gas grenade", "Signal distruptor", "Armor panel", "Cardiac sensor", "Stim pistol", "Armor pack", "EED", "Mounted LMG", "Active defense", "Shock wire", "Welcome mat", "Black eye", "Silent step", "Yokai", "Black mirror", "Gu mine", "Grzmot mine", "ERC-7", "Evil eye", "Prisma", "CCE-Shield", "Electro claw", "Pest launcher", "Glance smart glasses", "Volcan shield"];
        $abilitienames2 = ["Breaching hammer", "EMP grenade", "Breaching round", "Exo-thermic charge", "Shock drone", "Extandable shield", "Flip sight", "Cluster charge", "G52-Tactical shield", "Electronic detector", "Skeleton key", "Rifle shield", "Fire arrow", "Smoke arrow", "X-Kairos", "Eyenox", "Candela", "Impact grenade", "Concussion grenade", "Logic bomb", "EE-One-D", "Adrenaline surge", "Breaching torch", "Airjab", "Trax stringers", "HEL presence reduction", "Garra hook"];

        for($i = 0; $i < sizeof($mapList); $i++)
        {
            if($mapList[$i]->getName() == $map)
            {
                $roofIndex = $mapList[$i]->getRoofIndex();
            }
        }

        
        echo "<body id=\"body\" onload=\"init('$map', '$mod', '$obj', '$fileName', '$roofIndex')\">\n";
            echo "<div id=\"topBar\">\n";
                echo "<a id=\"home\" href=\"../../index.php\"><i class=\"fas fa-home\"></i></a>\n";
                echo "<p id=\"usernameTB\">".$_SESSION["topText"]."</p>\n";
                echo "<abbr title=\"Save data\"><i id=\"savedata\" class=\"fas fa-save\" onclick=\"saveData()\"></i></abbr>\n";
            echo END_DIV;
        
            if(file_exists(STRATS_PATH.$fileName))
            {
                include  "../UIScripts/LoadingScreen.php";
                $fileContent = null;
                $stratFile = fopen(STRATS_PATH.$fileName, "r");
                while(!feof($stratFile))
                {
                    $tmp = fgetc($stratFile);
                    if($tmp !== '"')
                    {
                        $fileContent .= $tmp;
                    }
                    else
                    {
                        $fileContent .= "¤";
                    }
                }
                echo "<img src=\"".IMG_PATH."abilitie/Active defense.png\" width=\"0\" height=\"0\" class=\"tosuppr\" id=\"tosuppr\" onload=\"endOfTransmission('$fileContent')\" >\n";
            }

            echo "<div id=\"mapdiv\"></div>\n";

            echo "<span id=\"mapCanvasSpan\" ondragover=\"allowDrop(event)\" ondrop=\"drop(event)\"><canvas id=\"mapCanvas\"></canvas></span>\n";

            echo "<div class=\"leftMenu\">\n";

                echo "<span class=\"tabSelector\">\n";
                    echo "<span id=\"contentListTab\" class=\"selected\" onclick=\"tabsManager('contentListTab', 'imgPropertiesTab')\"><span>Content List</span></span>\n";
                    echo "<span id=\"imgPropertiesTab\" onclick=\"tabsManager('imgPropertiesTab', 'contentListTab')\"><span>Image properties</span></span>\n";
                echo END_SPAN;
                echo "<span class=\"tabContent\">\n";
                    echo "<span id=\"contentList\" readOnly>\n<dl></dl>\n</span>\n";
                    echo "<span id=\"imgProperties\">\n";
                        echo "<span id=\"imgPropertiesMsg\"></span>\n";
                        echo "<span class=\"imgPropSize\">\n";
                            echo "<span class=\"imgPropTitle\">Size :</span>\n";
                            echo "<span class=\"modificators\">\n";
                                echo "<i class=\"fas fa-compress-arrows-alt\" id=\"resize\" onclick=\"resize(-1)\"></i>\n";
                                echo "<i class=\"fas fa-expand-arrows-alt\" id=\"resize\" onclick=\"resize(1)\"></i>\n";
                            echo END_SPAN;
                        echo END_SPAN;
                        echo "<span class=\"imgPropRotate\">\n";
                            echo "<span class=\"imgPropTitle\">Rotation :</span>\n";
                            echo "<span class=\"modificators\">\n";
                                echo "<i class=\"fas fa-undo\" id=\"rotate\" onclick=\"rotate(-1)\"></i>\n";
                                echo "<i class=\"fas fa-redo\" id=\"rotate\" onclick=\"rotate(1)\"></i>\n";
                            echo END_SPAN;
                        echo END_SPAN;
                        echo "<span class=\"imgPropFloor\">\n";
                            echo "<span class=\"imgPropTitle\">Floor</span>\n";
                            echo "<span class=\"modificators\">\n";
                                for($i = 0; $i <= $roofIndex; $i++)
                                {
                                    echo "<input class=\"changeImgFloor\" id=\"$i\" type=\"button\" value=\"".($i + 1)."\" onclick=\"goToFloor($i)\" />\n";
                                }
                            echo END_SPAN;
                        echo END_SPAN;
                        echo "<span class=\"imgPropDel\">\n";
                            echo "<span class=\"modificators\">\n";
                                echo "<i class=\"fas fa-trash-alt\" id=\"delete\" onclick=\"deleteImage()\"></i>\n";
                            echo END_SPAN;
                        echo END_SPAN;
                    echo END_SPAN;
                echo END_SPAN;
            echo END_DIV;

            echo "<div class=\"rightMenu\">\n";

                echo "<span class=\"selectorsLists\">\n";
                    echo "<span class=\"operatorsselector\">\n";
                        if($mod == "atk")
                        {
                            $in = sizeof($opnames) / 2;
                        }
                        else if($mod == "def")
                        {
                            $in = 0;
                        }
                        for($i = $in; $i < (sizeof($opnames) / 2 + $in); $i++)
                        {
                            echo "<span><abbr title=\"$opnames[$i]\"><img id=\"$opnames[$i]-icon\" ondragstart=\"drag(event)\" draggable name=\"operator,$opnames[$i]\" src=\"".IMG_PATH."operator/$opnames[$i].jpg\" /></abbr></span>\n";
                        }
                    echo END_SPAN;
                    echo "<span class=\"abilitieselector\">\n";
                    if($mod == "atk")
                    {
                        for($i = 0; $i < sizeof($abilitienames2); $i++)
                        {
                            echo "<span><abbr title=\"$abilitienames2[$i]\"><img id=\"$abilitienames2[$i]-icon\" onclick=\"newImage('abilitie', '$abilitienames2[$i]')\" src=\"".IMG_PATH."abilitie/$abilitienames2[$i].png\" /></abbr></span>\n";
                        }
                    }
                    else if($mod == "def")
                    {
                        for($i = 0; $i < sizeof($abilitienames1); $i++)
                        {
                            echo "<span><abbr title=\"$abilitienames1[$i]\"><img id=\"$abilitienames1[$i]-icon\" onclick=\"newImage('abilitie', '$abilitienames1[$i]')\" src=\"".IMG_PATH."abilitie/$abilitienames1[$i].png\" /></abbr></span>\n";
                        }
                    }
                    echo END_SPAN;
                    echo "<span class=\"gadgetsselector\">\n";
                        if($mod == "atk")
                        {
                            $in = 5;
                        }
                        else if($mod == "def")
                        {
                            $in = 0;
                        }
                        for($i = $in; $i < (sizeof($gadgetsnames) - 5 + $in); $i++)
                        {
                            echo "<span><abbr title=\"$gadgetsnames[$i]\"><img id=\"$gadgetsnames[$i]-icon\" onclick=\"newImage('gadget', '$gadgetsnames[$i]')\" src=\"".IMG_PATH."gadget/$gadgetsnames[$i].png\" /></abbr></span>\n";
                        }

                        if($mod == "def")
                        {
                            echo "<span><abbr title=\"Reinforced wall\"><img id=\"addreinforcedwall\" src=\"".IMG_PATH."reinforcedwall/Reinforced wall.png\"/></abbr></span>\n";
                            echo "<span><abbr title=\"Rotation\"><img id=\"addrotation\" src=\"".IMG_PATH."rotation/Rotation.png\" onclick=\"newImage('rotation', 'Rotation')\" /></abbr></span>\n";
                        }
                        else if($mod == "atk")
                        {
                            echo "<span><abbr title=\"Drone\"><img id=\"adddrone\" src=\"".IMG_PATH."drone/drone.png\" onclick=\"newImage('drone', 'Drone')\" /></abbr></span>\n";
                            echo "<span><abbr title=\"Defuser\"><img id=\"adddefuser\" src=\"".IMG_PATH."defuser/defuser.jpg\" onclick=\"newImage('defuser', 'Defuser')\" /></abbr></span>\n";
                        }
                    echo END_SPAN;
                echo END_SPAN;

            echo END_DIV;
            
            

            echo "<div id=\"msgBox\"><p id=\"msgTxt\"></p></div>\n";
            
            echo "<form name=\"jsonform\" action=\"../utils/saveData.php?path=".$map."¤".$mod."¤".$obj."¤".$fileName."\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"jsonTxt\">";
            echo "</form>";
            
            echo "<abbr title=\"Upper floor\"><i class=\"changeFloor fas fa-arrow-up\" onclick=\"upperFloor()\"></i></abbr>\n";
            echo "<abbr title=\"Lower floor\"><i class=\"changeFloor fas fa-arrow-down\" onclick=\"lowerFloor()\"></i></abbr>\n";
            ?>

    </body>
    
</html>