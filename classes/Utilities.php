<?php

class Utilities
{
    public function GetParam($param_name, $default = NULL) {
        if (isset($_GET[$param_name])) {
            return $_GET[$param_name];
        }
        if (isset($_POST[$param_name])) {
            return $_POST[$param_name];
        }
        else {
            return $default;
        }  
    }

    public function GetAllParams()
    {
        $result = [];

        if (count($_GET) != 0)
        {
            foreach ($_GET as $key => $value)
            {
                $result[$key] = $value;
            }
        }
        else
        {
            foreach ($_POST as $key => $value)
            {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function headerLocation($location, $params)
    {
        global $session;

        if ($session->isAuthorized())
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                $location = $location.'?'.session_name().'='.session_id();
            }
            else
            {
                $_SESSION['POST'][session_name()] = session_id();
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if (strpos($location, '?'))
            {
                foreach ($params as $key => $value) {
                    $location = $location.'&'.$key.'='.$value;
                }
                header('Location: '.$location, true, 301);
            }
            else
            {
                $question_mark_inserted = false;
                foreach ($params as $key => $value) {
                    if (!$question_mark_inserted) {
                        $question_mark_inserted = true;
                        $location = $location.'?'.$key.'='.$value;
                    }
                    else {
                        $location = $location.'&'.$key.'='.$value;
                    }
                }
                header('Location: '.$location, true, 301);
            }
        }
        else
        {
            foreach ($params as $key => $value) {
                $_SESSION['POST'][$key] = $value;
            }
            $_SESSION['POST']['asdf'] = 'qwer';
            header('Location: '.$location, true, 301);
        }
        
        die();
    }

    public function error($error_msg, $debug_msg = '')
    {
        $controller = new ErrorController();

        if (DEBUG_MODE && $debug_msg != '') {
            $controller->actionPrintError($error_msg, $debug_msg);
        } else {
            $controller->actionPrintError($error_msg);
        }
        die();
    }
}