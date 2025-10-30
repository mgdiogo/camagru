<?php 

class FeedController extends Controller {
	public function index() {
		$this->render('/pages/feed', ['title' => 'Feed']);
	}
}