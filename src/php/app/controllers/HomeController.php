<?php

require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
	public function index(): void {
		$this->render('/pages/home', ['title' => 'Camagru']);
	}
}