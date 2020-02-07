<?php

    include_once "Defines.php";

class User
{
    private $NAME = "";
    private $FILEACCESSLIST = [];
    private $FILEACCESSLISTPERSO = [];

    public function __construct($str, $arr1, $arr2)
    {
        $this->NAME = $str;
        if($arr1 !== null)
        {
            $this->FILEACCESSLIST = $arr1;
        }
        else
        {
            $this->FILEACCESSLIST = [];
        }
        
        if($arr2 !== null)
        {
            $this->FILEACCESSLISTPERSO = $arr2;
        }
        else
        {
            $this->FILEACCESSLISTPERSO = [];
        }
    }

    public function getName()
    {
        return $this->NAME;
    }

    public function getList()
    {
        return $this->FILEACCESSLIST;
    }

    public function getListPerso()
    {
        return $this->FILEACCESSLISTPERSO;
    }

    public function getListIndex($fileName)
    {
        for($i = 0; $i < sizeof($this->FILEACCESSLIST); $i++)
        {
            if($this->FILEACCESSLIST[$i] == $fileName)
            {
                return $i;
            }
        }

        $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "USC001";
        $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
        echo TEXT_PAGE_LOCATION;
    }

    public function rename($oldValue, $newValue)
    {
        if(rename(USERS_PATH.$oldValue.JSON_EXTENSION, USERS_PATH.$newValue.JSON_EXTENSION))
        {
            $this->NAME = $newValue;
            $this->saveJSON();
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "USC002";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }

    public function addToList($fileName)
    {
        $itsAnUpdate = 0;
        for($i = 0; $i < sizeof($this->FILEACCESSLIST); $i++)
        {
            if($this->FILEACCESSLIST[$i] == $fileName)
            {
                $itsAnUpdate = 1;
            }
        }
        if($itsAnUpdate == 0)
        {
            array_push($this->FILEACCESSLISTPERSO, $fileName);
            array_push($this->FILEACCESSLIST, $fileName);
        }
        $this->saveJSON();
    }

    public function removeFromList($fileName)
    {
        $tmpArr = [];
        $tmpArr2 = [];
        for($i = 0; $i < sizeof($this->FILEACCESSLIST); $i++)
        {
            if($this->FILEACCESSLIST[$i] !== $fileName)
            {
                array_push($tmpArr, $this->FILEACCESSLIST[$i]);
                array_push($tmpArr2, $this->FILEACCESSLISTPERSO[$i]);
            }
        }

        $this->FILEACCESSLIST = $tmpArr;
        $this->FILEACCESSLISTPERSO = $tmpArr2;
        $this->saveJSON();
    }

    public function replaceInList($oldValue, $newValue)
    {
        $tmpArr = [];
        for($i = 0; $i < sizeof($this->FILEACCESSLISTPERSO); $i++)
        {
            if($this->FILEACCESSLISTPERSO[$i] == $oldValue)
            {
                array_push($tmpArr, $newValue);
            }
            else
            {
                array_push($tmpArr, $this->FILEACCESSLISTPERSO[$i]);
            }
        }
        
        $this->FILEACCESSLISTPERSO = $tmpArr;
        $this->saveJSON();
    }

    public function getJSON()
    {
        
        $str = "{\"name\" : \"".$this->NAME."\", \"fileAccessList\" : [";

            for($i = 0; $i < sizeof($this->FILEACCESSLIST); $i++)
            {
                $str .= "\"".$this->FILEACCESSLIST[$i]."\"";
                if(sizeof($this->FILEACCESSLIST) > 1 && $i < (sizeof($this->FILEACCESSLIST) - 1))
                {
                    $str .= ", ";
                }
            }

            $str .= "], \"fileAccessListPerso\" : [";

            for($i = 0; $i < sizeof($this->FILEACCESSLISTPERSO); $i++)
            {
                $str .= "\"".$this->FILEACCESSLISTPERSO[$i]."\"";
                if(sizeof($this->FILEACCESSLISTPERSO) > 1 && $i < (sizeof($this->FILEACCESSLISTPERSO) - 1))
                {
                    $str .= ", ";
                }
            }

            return $str . "] }";
    }

    public function saveJSON()
    {
        $userFile = fopen(USERS_PATH.$this->NAME.JSON_EXTENSION, "w");
        fwrite($userFile, $this->getJSON());
        fclose($userFile);
    }

    public function isOwner($fileName)
    {
        for($i = 0; $i < sizeof($this->FILEACCESSLIST); $i++)
        {
            if($this->FILEACCESSLIST[$i] == $fileName)
            {
                return 1;
            }
        }
        return 0;
    }
}

?>