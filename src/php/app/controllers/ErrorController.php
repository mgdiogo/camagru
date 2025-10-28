<?php 

class ErrorController extends Controller {
	public function index(): void {
		$this->render('/errors/not_found', ['title' => 'Page not found']);
	}
}