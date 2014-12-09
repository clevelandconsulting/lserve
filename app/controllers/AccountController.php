<?php

class AccountController extends BaseController {

 private $accounts;

 public function __construct() {
	 $this->accounts = new Accounts();
 }

	public function index($id=null) {
		if($id=='' || $id==null) $response = $this->accounts->getAll();
 	else $response = $this->accounts->get($id);
 	 
 	$code = ($response === null) ? 404 : 200;
 	
 	return Response::json($response,$code);
	}
	
	public function update($id) {
	
		$email = Input::get('email');
		$company = Input::get('company');
		$userCount = Input::get('userCount');
		$license = Input::get('license');
		
		try {
			$account = $this->accounts->get($id);
			
			if ( $id !== null ) {
				$account->email = $email;
				$account->company = $company;
				$account->userCount = $userCount;
				$account->save();
				
				if($license) {
					$id = $license['id'];
					
					if ( $id != '') {
					 $db = new License();
					 unset($license['id']);
					 $result = $db->set($id,$license);
					}
					
				}
			}
			
			$message = $account;
			$code = 200;
		}
		catch(Exception $e) {
			$message = array('error'=>array('message'=>$e->getMessage()));
			$code = 500;
		}
		finally {
			return $this->json($message,$code);
		}
		
	}
	
	private function json($message,$code) {
		return Response::json($message,$code);
	}
	
	public function remove($id) {
		try {
			$result = $this->accounts->remove($id);
			$message = 'Deleted!';
			$code = 203;
		}
		catch (Exception $e) {
			$message = array('error'=>array('message'=>$e->getMessage() ));
		 $code = 500;
	 }
	 finally {
		 return Response::json($message,$code);
	 }	
	}
	
	public function add() {
		$email = Input::get('email');
		$company = Input::get('company');
		$userCount = Input::get('userCount');
		try {
 		$message = $this->accounts->create($email,$company,$userCount);
   $code = 201;
	 }
	 catch ( Exception $e ) {
		 $message = array('error'=>array('message'=>$e->getMessage()));
		 $code = 500;
	 }
	 finally {
		 return Response::json($message,$code);
	 }	
		
	}

}
