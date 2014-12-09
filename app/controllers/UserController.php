<?php

class UserController extends BaseController {

 private $users;

 public function __construct() {
	 $this->users = new Users();
 }

	public function index($id=null) {
		if($id=='' || $id==null) $response = $this->users->getAll();
 	else $response = $this->users->get($id);
 	 
 	$code = ($response === null) ? 404 : 200;
 	
 	return Response::json($response,$code);
	}
	
	public function update($id) {
	
		$email = Input::get('email');
		
		try {
			$user = $this->users->get($id);
			
			if ( $id !== null ) {
				$user->email = $email;
				$user->save();				
				}
			
			$message = $user;
			$code = 200;
			return Response::json($message,$code);
		}
		catch(Exception $e) {
			$message = array('error'=>array('message'=>$e->getMessage()));
			$code = 500;
			return Response::json($message,$code);
		}
		//finally {
		//	return $this->json($message,$code);
		//}
		
	}
	
	private function json($message,$code) {
		return Response::json($message,$code);
	}
	
	public function remove($id) {
		try {
			$result = $this->users->remove($id);
			$message = 'Deleted!';
			$code = 203;
			return Response::json($message,$code);
		}
		catch (Exception $e) {
			$message = array('error'=>array('message'=>$e->getMessage() ));
		 $code = 500;
		 return Response::json($message,$code);
	 }
	 //finally {
		 //return Response::json($message,$code);
	 //}	
	}
	
	public function add() {
		$email = Input::get('email');
		$password = Input::get('password');
		try {
 		$message = $this->users->create($email,$password);
   $code = 201;
   return Response::json($message,$code);
	 }
	 catch ( Exception $e ) {
		 $message = array('error'=>array('message'=>$e->getMessage()));
		 $code = 500;
		 return Response::json($message,$code);
	 }
	 //finally {
		 //return Response::json($message,$code);
	 //}	
		//return Response::json(array('properties'=>$purchase->properties, 'id'=>$purchase->key),201);
		
	}

}
