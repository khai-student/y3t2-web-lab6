<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Europe/Kiev" );  // http://www.php.net/manual/en/timezones.php
define( "DB_HOST", "localhost" );
define( "DB_PORT", "3306" );
define( "DB_DBNAME", "mysql" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "root" );
define( "DEBUG_MODE", true );

spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Controller') !== false) {
        include '/controllers/' . lcfirst ($class_name) . '.php';
    }
    elseif (strpos($class_name, 'Model') !== false) {
        include '/models/' . lcfirst ($class_name) . '.php';
    }
    elseif (strpos($class_name, 'View') !== false) {
        include '/view/' . lcfirst ($class_name) . '.php';
    }
    else {
        include '/classes/' . $class_name . '.php';
    }
});

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.<br><br>";
  echo $exception->getMessage();
}

set_exception_handler( 'handleException' );

$db = new Database();
$session = new Session();
$utilities = new Utilities();
?>
