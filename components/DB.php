<?php

namespace App\Components;

abstract class DB {
	private static $config = [
		'host' => 'localhost',
		'port' => '3306',
		'database_name' => "webby_lab",
		'user_name' => 'root',
		'password' => ''
	];
	private static $connection = null;

	private static function setConnection()
	{
		$config = static::$config;
		$dsn = "mysql:host=" . $config['host'] . ";port=" . $config['port'] . ";dbname=" . $config['database_name'] . ";charset=utf8";
		$options = [
	      	\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
	      	\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
	    ];
		$pdo = new \PDO($dsn, $config['user_name'], $config['password'], $options);
		static::$connection = $pdo;
	}

	public static function getConnection()
	{
		if (!static::$connection)
			static::setConnection();
		return static::$connection;
	}
}