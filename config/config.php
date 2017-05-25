<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config([

	'database' => [
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname'   => 'test',
		'charset'  => 'utf8',
	],

	'application' => [
		'modelsDir' => APP_PATH . '/models/',
		'baseUri'   => '/',
	],

]);