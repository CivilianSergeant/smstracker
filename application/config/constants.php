<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
if(empty($_SERVER['HTTPS'])) $http='http://'; else $http='https://';

if(preg_match("/wamp/", $_SERVER['DOCUMENT_ROOT']))
 define('BASE',        $http.$_SERVER['SERVER_NAME'].'/sms_tracker/');
else if(preg_match("/lamp/", $_SERVER['DOCUMENT_ROOT']) || preg_match("//var/www/", $_SERVER['DOCUMENT_ROOT']))
 define('BASE',        $http.$_SERVER['SERVER_NAME'].'/sms_tracker/');
else if(preg_match("/xampp/", $_SERVER['DOCUMENT_ROOT']))
 define('BASE',        $http.$_SERVER['SERVER_NAME'].'/');
else 
 define('BASE',        $http.$_SERVER['SERVER_NAME'].'/');


define('JS',BASE.'media/js/');
define('CSS',BASE.'media/css/');
define('IMAGE',BASE.'media/image/');

define('REFUND_BALANCE_LIMIT',8000);
define('DEFAULT_SMS_LIMIT',40);
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */