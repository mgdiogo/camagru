<?php

class Router
{
	public function __construct(private array $routes) {}

	public function handleRequest(): void {
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		if (isset($this->routes[$uri])) {
			$route = $this->routes[$uri];
			$this->dispatch($route['controller'], $route['method']);
			return;
		}

		$segments = explode('/', trim($uri, '/'));
		$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'ErrorController';
		$method = $segments[1] ?? 'index';

		if (class_exists($controllerName)) {
			$controller = new $controllerName();
			if (method_exists($controller, $method)) {
				$controller->$method();
				return;
			}
		}

		$this->handle_404();
	}


	private function dispatch(string $controllerName, string $method): void {
		if (class_exists($controllerName)) {
			$controller = new $controllerName();
			if (method_exists($controller, $method))
				$controller->$method();
		} else
			$this->handle_404();
	}

	private function handle_404(): void
	{
		if (isset($this->routes['/not_found'])) {
			http_response_code(404);
			$route = $this->routes['/not_found'];
			$this->dispatch($route['controller'], $route['method']);
		}
	}
}