<?php
	
	class License extends LaravelFlintstoneModel {
  
  public function getObjectName() {
	  return 'license';
  }
		
		public function set($id, $email, $name='',$key='', $active='', $suspended='',$date='') {
			if (is_array($email)) {
				$this->db->set($id,$email);
			}
			else{
			 $this->db->set($id,array('email'=>$email,'name'=>$name,'key'=>$key,'active'=>$active,'suspended'=>$suspended, 'date'=>$date));
			}
		}
		
	}