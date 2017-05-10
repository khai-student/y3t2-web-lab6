<?php
require_once 'config.php';

global $utilities;
// controller to activate
$controller = null;
// action to choose
$action = null;
// other passed parameters
$params = $utilities->GetAllParams();

//
$route = $utilities->GetParam('r', null);
if ($route == null)
{
     $utilities->headerLocation('Location: router.php?r=section/index&section=strings');
}
// if route is passed  
$route = explode('/', $route);
if (count($route) != 2) Error('400 Wrong route');

switch (strtolower($route[0])) // controller name
{
    case 'section':
        $controller = new SectionController();
        break;
    case 'advancedinfo':
        $controller = new AdvancedInfoController();
        break;
    case 'auth':
        $controller = new AuthController();
        break;
    default:
        $utilities->error('400 Wrong route');
        break;
}

switch (strtolower($route[1])) // action
{
    case 'index':
        $action = 'actionIndex';
        break;
    case 'edit':
        global $session;
        if (!$session->isAuthorized())
        {
            $utilities->headerLocation("Location: router.php?r=auth/login");
        }
        if (!$session->isAdmin()) 
        {
            $utilities->error('400 Access not granted.');
        }
        $action = 'actionEdit';
    case 'signin':
        if (strtolower($route[0]) == 'auth')
            $action = 'actionSignIn';
        else
            $action = 'actionIndex';
        break;
    case 'signup':
        if (strtolower($route[0]) == 'auth')
            $action = 'actionSignUp';
        else
            $action = 'actionIndex';
        break;
    case 'signout':
        if (strtolower($route[0]) == 'auth')
            $action = 'actionSignOut';
        else
            $action = 'actionIndex';
        break;
    default:
        $utilities->error("Don't touch URL!");
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
    $utilities->error('500 Internal server error', $e->GetMessage());
}
die();

?>