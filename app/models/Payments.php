<?php
	
	class Payments extends LaravelFlintstoneModel {
		
		public function getObjectName() {
			return 'payment';
		}
		
		public function create($accountId,$date,$amount) {
			$id = uniqid();
			$this->db->set($id,array('accountId'=>$accountId,'date'=>$date,'amount'=>$amount));
			return $this->get($id);
		}
		
		public function remove($id) {
			$this->db->delete($id);
		}
		
	}