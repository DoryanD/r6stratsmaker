<?php

    class Filter
    {
        private $NAME = "";
        
        public function __construct($str)
        {
            $this->NAME = $str;
        }
        
        public function getName()
        {
            return $this->NAME;
        }

        public function applyFilter($rule_arr, $arr)
        {
            $tmp_arr = [];
            for($i = 0; $i < sizeof($rule_arr); $i++)
            {
                for($k = 0; $k < sizeof($arr); $k++)
                {
                    if($arr[$k] == $rule_arr[$i])
                    {
                        array_push($tmp_arr, $arr[$k]);
                    }
                }
            }

            return $tmp_arr;
        }
    }

    $mapFilter = new Filter("mapFilter");
    $modFilter = new Filter("modFilter");

?>