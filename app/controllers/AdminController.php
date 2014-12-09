<?php

class AdminController extends BaseController {

 private $accounts;

 public function __construct() {
	 $this->accounts = new Accounts();
 }

	public function showAccounts() {
		$message = Session::get('message');
		$objects = $this->accounts->getAll();
		
		//return print_r($objects,true);
		
		return View::make('accounts')->with(array("message"=>$message,"accounts"=>$objects));
	}
	
	public function update($id) {
		$email = Input::get('email');
		$company = Input::get('company');
		$userCount = Input::get('userCount');
		
		$account = $this->account->get($id);
		
		if ( $id !== null ) {
			$account->email = $email;
			$account->company = $company;
			$account->userCount = $userCount;
			$account->save();
		}
		
		return Redirect::to('/');
	}
	
	public function add() {
		$email = Input::get('email');
		$company = Input::get('company');
		$userCount = Input::get('userCount');
		
		$this->accounts->create($email,$company,$userCount);
		
		return Redirect::to('/');
	}

}
