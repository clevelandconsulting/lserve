<?php namespace Cci\LaravelFlintstone;
	
use Flintstone\Flintstone;
	
	class LaravelFlintstone {
		private $options;
		
		public function __construct($options) {
			$this->options = $options;
		}
		
		public function load($object) {
			return Flintstone::load($object, $this->options);
		}
		
	}