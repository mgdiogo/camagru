<?php

class Routes {
	public function __construct(private array $routes) {}

	public function handleRequest(): void {
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		if (isset($this->routes[$uri])) {
			$route = $this->routes[$uri];
			$controller = new $route['controller'];
			$method = $route['method'];

			if (method_exists( $controller, $method ))
				$controller->$method();
		}
	}
}