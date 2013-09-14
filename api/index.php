<?php
require 'config.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
	
// Default Page
$route = '/v1/';
$app->get($route, function () {
    
});	

// Default Page
$route = '/';
$app->get($route, function () {
    
});	

//  Facilities
include "methods/facilities.php";

//  Programs
include "methods/programs.php";

//  Press
include "methods/press.php";

$app->run();	



