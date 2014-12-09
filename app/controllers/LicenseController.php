<?php
	
class LicenseController extends BaseController {
	
	private $model;
	
	public function __construct() {
		$this->model = new License();
	}
	
	public function register() {
		$email = Input::get('email');
		$company = Input::get('company');
		
		$id = $email."|".$company;
		
		try {
		
			$object = $this->model->get($id);
			
			if($object == null) {
				$account = $this->findByAccount($email,$company);
				if ($account != null) {
					
					$key = $this->create($id,$email,$company);
					$account->license = array('id'=>$id,'key'=>$key);
					$account->save();
					
					$message = array('license'=>$key);
					$code = 201;
				}
				else {
					$message = array('error'=>array('message'=>'No account found'));
					$code = 404;
				}
			}
		 else {
			 $message = array('license'=>$object->properties['key']);
			 $code = 200;
		 }
  }
  catch(Exception $e) {
	  $message = array('error'=>array('message'=>$e->getMessage()));
	  $code = 500;
  }	
  finally {
 		return Response::json($message,$code);
	 }	
		
	}
	
	public function fetch($key) {

  try {
	  $userCount = Input::get("userCount");
	  
			$license = $this->model->findBy('key',$key);
			$license = sizeOf($license)>0 ? $license[0] : null;
			
			if ($license != null) {
				if ($license->suspended) $message = array('status'=>'suspended', 'message'=>'Your account has been suspended.');
				elseif ( $license->active ) {
					$accounts = new Accounts();
					$account = $accounts->findBy(array('email','company'),array($license->email,$license->properties['name']));
					
					$account = sizeof($account)>0?$account[0]:null;
					if ($account !== null) {
						if ( $account->userCount < $userCount ) $message = array('status'=>'active', 'message'=>'You have exceeded your user count of ' . $account->userCount . '.');
						else $message = array('status'=>'active', 'message'=>'Welcome!');
					}
					else $message = array ('status'=>'notfound', 'message'=>'Your account was not found.')
					;
				}
				else $message = array('status'=>'inactive', 'message'=>'Your account has been suspended.');
				
				$code = 200;
			}
			else {
				$message = array('error'=>array('message'=>'No license found for key: ' . $key));
				$code = 404;
			}
  }
  catch(Exception $e) {
	  $message = array('error'=>array('message'=>$e->getMessage(), 'line'=>$e->getLine()));
	  $code = 500;
  }	
  finally {
 		return Response::json($message,$code);
	 }	
	}
	
	private function create($id,$email,$name) {
		$key = uniqid();
		$this->model->set($id, $email, $name, $key, true, false, date("Y-m-d"));
		return $key;
	}
	
	private function findByAccount($email,$company) {
		$accounts = new Accounts();
		$account = $accounts->findBy(array('email','company'),array($email,$company));
		
		return sizeof($account) > 0 ? $account[0] : null;
	}
	
}