<?php
	
$route = new System\Route\Router();

$route->get('/', 'HomeController@index');
$route->get('webtoken', 'HomeController@JwtwebToken');
$route->get('guzzle', 'HomeController@guzzle');