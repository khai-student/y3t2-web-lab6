<?php

class Utilities
{
    public function GetParam($param_name, $default = NULL) {
        if (isset($_POST[$param_name])) {
            return $_POST[$param_name];
        }
        if (isset($_GET[$param_name])) {
            return $_GET[$param_name];
        }
        else {
            return $default;
        }  
    }

    public function GetAllParams()
    {
        $result = [];

        if (count($_POST) != 0)
        {
            foreach ($_POST as $key => $value)
            {
                $result[$key] = $value;
            }
        }
        else
        {
            foreach ($_GET as $key => $value)
            {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}