<?php 

class ErrorController extends Controller {
	public function not_found(): void {
		$this->render('/errors/not_found', ['title' => 'Page not found']);
	}

	public function server_error(): void {
		$this->render('/errors/server_error', ['title' => 'Internal server error']);
	}
}