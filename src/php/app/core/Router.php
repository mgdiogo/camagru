<?php

class Router
{
	public function __construct(private array $routes)
	{
	}

	public function handleRequest(): void
	{
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		if (isset($this->routes[$uri])) {
			$route = $this->routes[$uri];
			$controller = new $route['controller'];
			$method = $route['method'];

			if (method_exists($controller, $method)) {
				$controller->$method();
				return;
			}
		}

		$this->handle_404();
	}

	private function handle_404(): void
	{
		if (isset($this->routes['/not_found'])) {
			$route = $this->routes['/not_found'];
			$controller = new $route['controller'];
			$method = $route['method'];

			http_response_code(404);
			if (method_exists($controller, $method)) {
				$controller->$method();
				return;
			}
		}
	}
}