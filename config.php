<?php
date_default_timezone_set('Europe/Kiev');

define('SALT', "mimimi");
define('TEMPLATE', "templates/html/");
define('LANG', "templates/lang/");

//home
define('DB_HOST', 'localhost');
define('DB_NAME', 'booker');
define('DB_PASS', '');
define('DB_LOGIN', 'root');

define('PATH', '/');

define('CONTROLLER', '0');
define('ACTION', '1');
define('PARAM', '2');

/*
//work
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'user2');
define('DB_NAME', 'user2');
define('DB_PASS','tuser2');

define('PATH', '/~user2/PHP/booker/');

define('CONTROLLER', '3');
define('ACTION', '4');
define('PARAM', '5');

define('TEMPLATE', "/usr/home/user2/public_html/PHP/booker/templates/html/");
define('LANG', "/usr/home//user2/public_html/PHP/booker/templates/lang/");
*/
//encode
define('STRING_LENGHT', 10);
//error
define('ERROR_EMPTY', 'Field is empty');
define('ERROR_WRONG_DATA', 'Wrong data');
define('ERROR_ACCESS', 'Wrong name or password');
define('ERROR_EXISTS', 'E-mail or name already exists');
?>
