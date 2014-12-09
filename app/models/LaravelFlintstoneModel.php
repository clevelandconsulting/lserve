<?php
	
	abstract class LaravelFlintstoneModel {
		protected $db;
		
		public function __construct() {
			$this->db = LaravelFlintstone::load($this->getObjectName());
		}
		
		public function get($id) {
			$properties = $this->db->get($id);
			if ( is_array($properties) ) {
				return new LaravelFlintstoneObject($id,$properties,$this->getObjectName());
			}
			return null;
		}
		
		public function getAll() {
			$objects = array();
			$keys = $this->db->getKeys();
			foreach ($keys as $key) {
				$object = $this->get($key);
				if ($object !== null) {
 				array_push($objects,$object);
 			}
			}
			return $objects;
		}
		
		public function findBy($keys,$values) {
		$object = null;
		$foundObject = array();
		
		foreach ($this->db->getKeys() as $key) {
		 $object = $this->db->get($key);
		 $keysMatch = true;
		 
		 if (is_array($keys)) {
			 
			 for ($i=0;$i<count($keys);$i++) {
			  if ($object[$keys[$i]] !== $values[$i]) {
				  $keysMatch = false;
				  break;
			  }
			 }
			 
			}
			else {
				 if ($object[$keys] !== $values) $keysMatch = false;
			}
			 
			if ($keysMatch) {
				 $lfObj = new LaravelFlintstoneObject($key,$object,$this->getObjectName());
			  array_push($foundObject,$lfObj);
			}
		
		}
		
		//if ( $foundObject == null ) $object = null;
		//else $object = new LaravelFlintstoneObject($foundObject,$object,$this->getObjectName());
		
		return $foundObject;
	}
		
	abstract public function getObjectName();
		
	}