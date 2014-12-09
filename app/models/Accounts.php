<?php
	
	class Accounts extends LaravelFlintstoneModel {
		
		public function getObjectName() {
			return 'account';
		}
		
		public function get($id) {
			$account = parent::get($id);
			
			if ( $account != null && array_key_exists('license', $account->properties) ) {
				$db = new License();
				$licenseId = $account->properties['license']['id'];
				$license = $db->get($licenseId);
				$licenseProperties = $license->properties;
				$licenseProperties['id'] = $licenseId;
				$account->license = $licenseProperties;
			}
			
			return $account;
		}
		
		public function create($email,$company,$userCount) {
			$id = uniqid();
			$this->db->set($id,array('email'=>$email,'company'=>$company,'userCount'=>$userCount));
			return $this->get($id);
		}
		
		public function remove($id) {
			$this->db->delete($id);
		}
		
	}