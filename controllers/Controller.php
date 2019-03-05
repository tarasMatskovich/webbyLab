<?php

namespace App\Controllers;

class Controller {
	// TODO: Вынести это в общий класс
	public function __call($methodName, $args)
	{
		throw new \Exception("Action:" . $methodName . " is not exist in file: " . static::class);
	}
}