<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Europe/Kiev" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=mysql" );
define( "DB_IP", "localhost" );
define( "DB_PORT", "5432" );
define( "DB_DBNAME", "mysql" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "root" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "ADMIN_USERNAME", "admin" );
define( "ADMIN_PASSWORD", "admin" );

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
?>
