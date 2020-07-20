<?php
	
$route = new System\Router\Router();

$route->get('/', 'HomeController@index');
$route->get('webtoken', 'HomeController@JwtwebToken');