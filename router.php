<?php
require_once 'config.php';

function Error($error_msg, $debug_msg = '')
{
    if ($route == null) {
        $controller = new ErrorController();

        if ($debug_msg != '') {
            $controller->printError($error_msg, $debug_msg);
        } else {
            $controller->printError($error_msg);
        }
        die();
    }
}

$tools = new Utilities();

// controller to activate
$controller = null;
// action to choose
$action = null;
// other passed parameters
$params = $tools->GetAllParams();

//
$route = $tools->GetParam('r', null);
if ($route == null)
{
     header('Location: router.php?r=section/index&section=strings');
     die();
}
// if route is passed  
$route = explode('/', $route);
if (count($route) != 2) Error('400 Wrong route');

switch ($route[0]) // controller name
{
    case 'section':
        $controller = new SectionController();
        break;
    case 'advancedInfo':
        $controller = new AdvancedInfoController();
        break;
    case 'auth':
        $controller = new AuthController();
        break;
    default:
        Error('400 Wrong route');
        break;
}

switch ($route[1]) // action
{
    case 'index':
        $action = 'actionIndex';
        break;
    case 'edit':
        global $session;
        
        if (!$session->isAuthorized())
        {
            header("Location: router.php?r=auth/login");
            die();
        }
        if (!$session->isAdmin()) Error('400 Access not granted.');
        $action = 'actionEdit';
    default:
        $action = $route[1];
        break;
}

// passing all parameters to controller
foreach ($params as $param => $value) {
    if ($param == 'r') continue;
    $controller->$param = $value;
}

try
{
    $controller->$action();
}
catch (Exception $e)
{
    Error('500 Internal server error', $e->GetMessage());
}
die();

?>