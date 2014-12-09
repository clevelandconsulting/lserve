<?php

class AccountPaymentController extends BaseController {

 private $payments;

 public function __construct() {
	 $this->payments = new Payments();
 }

	public function index($accountId,$id=null) {
		if($id=='' || $id==null) $response = $this->payments->findBy('accountId',$accountId);
 	else $response = $this->payments->get($id);
 	 
 	$code = ($response === null) ? 404 : 200;
 	
 	return Response::json($response,$code);
	}
	
	public function update($id) {
	
		$date = Input::get('date');
		$amount = Input::get('amount');
		
		try {
			$payment = $this->payments->get($id);
			
			if ( $id !== null ) {
				$payment->date = $date;
				$payment->amount = $amount;
				$payment->save();
			}
			
			$message = $payment;
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
			$result = $this->payments->remove($id);
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
	
	public function add($accountId) {
		#$accountId = Input::get('accountId');
		$date = Input::get('date');
		$amount = Input::get('amount');
		try {
 		$message = $this->payments->create($accountId,$date,$amount);
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
