<?php

    include_once "sessionStart.php";


    if(isset($_POST["mod"]))
    {
        $mod = strtolower($_POST["mod"]);
        $oldValue = $_POST[$mod."Text"].JSON_EXTENSION;
        $newValue = $_POST[$mod."Edit"];

        if($mod == "stratname")
        {
            $newValue = str_replace(" ", "_", $newValue);
            preg_match_all(REGEX_FILTER_STRATNAME, $newValue, $matches);
            $newValue = "";
            foreach($matches[0] as $str)
            {
                $newValue .= $str;
            }

            if(file_exists(STRATS_PATH.$oldValue))
            {
                $oldFileIndex = $user->getListIndex($oldValue);
                $accessListPerso = $user->getListPerso();
                $fileNamePerso = $accessListPerso[$oldFileIndex];

                if(strlen($newValue) >= 5 && strlen($newValue) <= 20)
                {
                    if($fileNamePerso !== $newValue.JSON_EXTENSION)
                    {
                        if($user->isOwner($oldValue))
                        {
                            $user->replaceInList($fileNamePerso, $newValue.JSON_EXTENSION);
                            echo INDEX_PAGE_LOCATION;
                        }
                        else
                        {
                            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CSS005";
                            $_SESSION[TEXT_MSG] = "The strategy you're trying to rename it's not yours";
                            echo TEXT_PAGE_LOCATION;
                        }
                    }
                    else
                    {
                        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CSS004";
                        $_SESSION[TEXT_MSG] = "This name match with one of your strategy";
                        echo TEXT_PAGE_LOCATION;
                    }
                }
                else
                {
                    $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CSS003";
                    $_SESSION[TEXT_MSG] = "The name must be between 5 and 20 characters long";
                    echo TEXT_PAGE_LOCATION;
                }
            }
            else
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CSS002";
                $_SESSION[TEXT_MSG] = "The file you're trying to access is not found";
                echo TEXT_PAGE_LOCATION;
            }
        }
        else
        {
            //nothing at this moment
        }
    }
    else
    {
        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "CSS001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }
    
?>