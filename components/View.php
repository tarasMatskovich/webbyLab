<?php

namespace App\Components;

abstract class View {
	public static function viewExist(string $viewName)
	{
		return file_exists(ROOT . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $viewName . ".php");
	}
	public static function render(string $viewName, array $args = []) {
		if (!static::viewExist($viewName)) 
			throw new \Exception("Error: View: " . $viewName . ".php - does not exist");
		extract($args);

		ob_start();
        include( ROOT . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $viewName . ".php");
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
	}
}