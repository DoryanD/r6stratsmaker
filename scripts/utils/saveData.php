<?php
    require "sessionStart.php";

echo "<!DOCTYPE html>";
echo "<html>";

    echo "<head>";
        echo "<meta charset=\"utf-8\" />";
        echo "<title>Saving...</title>";
    echo "</head>";
    
    echo "<body>";
        $path = $_GET["path"];
        $data = $_POST[JSON_TXT];
        $arr = explode("¤", $path);
        $map = $arr[0]; $mod = $arr[1]; $obj = $arr[2]; $fileName = $arr[3];
        if(file_exists(STRATS_PATH.$fileName))
        {
            if(!unlink(STRATS_PATH.$fileName))
            {
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SDA002";
                $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
                echo TEXT_PAGE_LOCATION;
            }
        }
        $stratFile = fopen(STRATS_PATH.$fileName, "w");
        $wroteChar = fwrite($stratFile, $data);
        if($wroteChar == strlen($data))
        {
            fclose($stratFile);
            $user->addToList($fileName);
            echo INDEX_PAGE_LOCATION;
        }
        else
        {
            fclose($stratFile);
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "SDA001";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
        ?>

    </body>
    
</html>