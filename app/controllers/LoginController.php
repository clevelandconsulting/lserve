<?php
	
	class LoginController extends BaseController {
		
		public function index() {
			$message = Session::get('message');
			return View::make('login')->with('message', $message);
		}
	}