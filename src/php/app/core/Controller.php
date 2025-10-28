<?php

class Controller {
	public function render(string $view, array $data = []): void {
		extract($data);
		require_once __DIR__ . '/../views' . $view . '.php';
	}
}