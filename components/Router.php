<?php

namespace App\Components;

use App\Components\Session;

class Router {
	protected $routes;

	public function __construct() {
		$this->routes = include(ROOT . '/routes/routes.php');
		$this->clearFlashMessages();
	}

	protected function clearFlashMessages()
	{
		Session::clearFlashMessage();
	}

	public function getRequestUri()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		} else {
			return null;
		}
	}

	protected function getResponse($res)
	{
		echo $res;
	}

	public function handle()
	{
		try {
			$uri = $this->getRequestUri();
		
			$internalRoute = null;
			foreach ($this->routes as $routePattern => $path) {
				if ($uri == "" && $routePattern == '/') {
					$internalRoute = $path;
					break;
				} elseif($uri != "" && preg_match("~^$routePattern$~", $uri)) {
					$internalRoute = preg_replace("~^$routePattern$~", $path, $uri);
					break;
				}
			}
			if (!$internalRoute) {
				throw new \Exception("Error: 404: Resource is not found");
			}
			$segments = explode("/", $internalRoute);
			$controllerName = ucfirst(array_shift($segments)) . "Controller";
			$fullControllerClassName = "App\\Controllers\\" . $controllerName;

			$controller = new $fullControllerClassName();

			$action = array_shift($segments);

			$parametrs = $segments;
			$result = call_user_func_array(array($controller,$action), $parametrs);
			$this->getResponse($result);
		} catch(\Exception $e) {
			echo $e->getMessage();
		}
	}
}