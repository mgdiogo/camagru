<?php

require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
	public function signup(): void {
		$this->render('/pages/home', ['title' => 'Camagru']);
	}

	public function login(): void { 
		$this->render('/pages/login', ['title' => 'Camagru']);
	}
}