<?php namespace Cci\LaravelFlintstone;
	
	use Illuminate\Auth\UserInterface;
	Use Flintstone\FlintstoneDB;
	
	class LaravelFlintstoneUser implements UserInterface {
	 
	 private $db;
	 private $key;
	 private $storage;
	 
	 public function __construct(FlintstoneDB $db, $key) {
		 $this->db = $db;
		 $this->key = $key;
		 $this->storage = $this->db->get($key);
	 }
	 
	 public function __get($name) {
		 return $this->storage[$name];
	 }
	 
	 /**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	 public function getAuthIdentifier() {
		 return $this->key;
	 }
	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {
		return $this->storage['password'];
	}
	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken() {
		return $this->storage[$this->getRememberTokenName()];
	}
	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value) {
		$this->storage[$this->getRememberTokenName()] = $value;
		$this->save();
	}
	
	public function save() {
		$this->db->set($this->key,$this->storage);
	}
	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName() {
		return 'remember_token';
	}
	 
	 
	 
	 
	 
	 	
	}