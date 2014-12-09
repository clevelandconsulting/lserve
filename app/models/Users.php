<?php
	
	class Users extends LaravelFlintstoneModel {
		
		public function getObjectName() {
			return 'user';
		}
		
		public function create($email,$password) {
			$id = uniqid();
			$this->db->set($id,array('email'=>$email,'password'=>Hash::make($password)) );
			return $this->get($id);
		}
		
		public function remove($id) {
			$this->db->delete($id);
		}
		
	}