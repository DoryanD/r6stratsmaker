<?php

    include_once "Defines.php";

class Team
{
    private $NAME = "";
    private $FOUNDERNAME = "";
    private $JOINREQUEST = [];
    private $STRATSSHARE = [];
    private $MEMBERSLIST = [];

    public function __construct($str1, $str2, $arr1, $arr2, $arr3)
    {
        $this->NAME = $str1;
        $this->FOUNDERNAME = $str2;
        if($arr1 !== null)
        {
            $this->JOINREQUEST = $arr1;
        }
        else
        {
            $this->JOINREQUEST = [];
        }
        
        if($arr2 !== null)
        {
            $this->STRATSSHARE = $arr2;
        }
        else
        {
            $this->STRATSSHARE = [];
        }

        if($arr3 !== null)
        {
            $this->MEMBERSLIST = $arr3;
        }
        else
        {
            $this->MEMBERSLIST = [];
        }
    }

    public function getName()
    {
        return $this->NAME;
    }

    public function getJoiningList()
    {
        return $this->JOINREQUEST;
    }

    public function getStartShareList()
    {
        return $this->STRATSSHARE;
    }

    public function getMembersList()
    {
        return $this->MEMBERSLIST;
    }

    public function rename($oldValue, $newValue)
    {
        if(rename(TEAMS_PATH.$oldValue.JSON_EXTENSION, USERS_PATH.$newValue.JSON_EXTENSION))
        {
            $this->NAME = $newValue;
            $this->saveJSON();
        }
        else
        {
            $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "TEC001";
            $_SESSION[TEXT_MSG] = INTERNAL_ERROR;
            echo TEXT_PAGE_LOCATION;
        }
    }

    public function newJoinRequest($username)
    {
        $alreadySent = 0;
        for($i = 0; $i < sizeof($this->JOINREQUEST); $i++)
        {
            if($this->JOINREQUEST[$i] == $username)
            {
                $alreadySent = 1;
                $_SESSION[TEXT_TYPE] = ERROR; $_SESSION[TEXT_CODE] = "TEC002";
                $_SESSION[TEXT_MSG] = "Your demand is already sent";
                echo TEXT_PAGE_LOCATION;
            }
        }
        if($alreadySent == 0)
        {
            array_push($this->JOINREQUEST, $username);
        }
        $this->saveJSON();
    }

    public function addMember($newbieName)
    {
        array_push($this->MEMBERSLIST, $newbieName);
        $this->removeFromList($newbieName, 0);
    }

    public function removeFromList($name, $listInd)
    {
        $tmpArr = [];
        if($listInd == 0)
        {
            for($i = 0; $i < sizeof($this->JOINREQUEST); $i++)
            {
                if($this->JOINREQUEST[$i] !== $name)
                {
                    array_push($tmpArr, $this->JOINREQUEST[$i]);
                }
            }
            $this->JOINREQUEST = $tmpArr;
        }
        else if($listInd == 1)
        {
            for($i = 0; $i < sizeof($this->STRATSSHARE); $i++)
            {
                if($this->STRATSSHARE[$i] !== $name)
                {
                    array_push($tmpArr, $this->STRATSSHARE[$i]);
                }
            }
            $this->STRATSSHARE = $tmpArr;
        }

        $this->saveJSON();
    }

    public function getJSON()
    {
        
        $str = "{\"teamName\" : \"".$this->NAME."\", \"founderName\" : \"".$this->FOUNDERNAME."\", \"joinRequest\" : [";

            for($i = 0; $i < sizeof($this->JOINREQUEST); $i++)
            {
                $str .= "\"".$this->JOINREQUEST[$i]."\"";
                if(sizeof($this->JOINREQUEST) > 1 && $i < (sizeof($this->JOINREQUEST) - 1))
                {
                    $str .= ", ";
                }
            }

            $str .= "], \"stratsShare\" : [";

            for($i = 0; $i < sizeof($this->STRATSSHARE); $i++)
            {
                $str .= "\"".$this->STRATSSHARE[$i]."\"";
                if(sizeof($this->STRATSSHARE) > 1 && $i < (sizeof($this->STRATSSHARE) - 1))
                {
                    $str .= ", ";
                }
            }

            $str .= "], \"members\" : [";
            
                        for($i = 0; $i < sizeof($this->MEMBERSLIST); $i++)
                        {
                            $str .= "\"".$this->MEMBERSLIST[$i]."\"";
                            if(sizeof($this->MEMBERSLIST) > 1 && $i < (sizeof($this->MEMBERSLIST) - 1))
                            {
                                $str .= ", ";
                            }
                        }

            return $str . "] }";
    }

    public function saveJSON()
    {
        $teamFile = fopen(TEAMS_PATH.$this->NAME.JSON_EXTENSION, "w");
        fwrite($teamFile, $this->getJSON());
        fclose($teamFile);
    }
}

?>