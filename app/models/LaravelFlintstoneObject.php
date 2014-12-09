<?php
	
	class LaravelFlintstoneObject {
		public $name;
		public $properties;
		public $key;
		
		public function __construct($key,$properties,$name) {
			$this->name = $name;
			$this->key = $key;
			$this->properties = $properties;
		}
		
		public function getKey() {
			return $this->key;
		}
		
		public function save() {
			$db = LaravelFlintstone::load($this->name);
			return $db->set($this->key,$this->properties);
		}
		
		public function __get($name) {
			return $this->properties[$name];
		}
		
		public function __set($name,$value) {
			$this->properties[$name] = $value;
		}
		
	}