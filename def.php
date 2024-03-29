<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
date_default_timezone_set("America/Mexico_City");

define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
switch (ENVIRONMENT) {
	case 'development':		
		error_reporting(-1);
		ini_set('display_errors', 1);
		// Motrar todos los errores de PHP
		error_reporting(-1);
		// Motrar todos los errores de PHP
		error_reporting(E_ALL);
		// Motrar todos los errores de PHP
		ini_set('error_reporting', E_ALL);		
		break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 1);		
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

$system_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'system';
$application_folder = 'app';
$view_folder = '';

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
	chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
	$system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
	// Ensure there's a trailing slash
	$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_path);
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));



if (is_dir($application_folder)) {
	if (($_temp = realpath($application_folder)) !== FALSE) {
		$application_folder = $_temp;
	} else {
		$application_folder = strtr(
			rtrim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
	}
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
	$application_folder = BASEPATH . strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
} else {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);
define('CONFPATH', FCPATH .'config'.DIRECTORY_SEPARATOR);
define('VIEWPATH', FCPATH ."views".DIRECTORY_SEPARATOR);
require FCPATH.'vendor/autoload.php';
require_once BASEPATH . 'core/CodeIgniter.php';

