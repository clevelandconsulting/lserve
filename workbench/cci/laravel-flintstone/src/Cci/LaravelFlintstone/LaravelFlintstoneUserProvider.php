<?php namespace Cci\LaravelFlintstone;
	
use Illuminate\Auth\UserProviderInterface,
    Illuminate\Auth\UserInterface,
    Flintstone\FlintstoneDB;

use Illuminate\Hashing\BcryptHasher as Hasher;
use Illuminate\Hashing\HasherInterface as HasherContract;



class LaravelFlintstoneUserprovider implements UserProviderInterface {
	
	public function getInstance() {
		return $this;
	}
	/**
	 * The hasher implementation.
	 *
	 * @var \Illuminate\Contracts\Hashing\Hasher
	 */
	protected $hasher;
	/**
	 * The Eloquent user model.
	 *
	 * @var string
	 */
	protected $model;
	
	protected $db;
	/**
	 * Create a new database user provider.
	 *
	 * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(HasherContract $hasher, LaravelFlintstone $flintstone)
	{
		$this->hasher = $hasher;
		$this->db = $flintstone->load('user');
	}
	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveById($identifier)
	{
		return $this->createModel($this->db, $identifier);
		//return $this->createModel()->newQuery()->find($identifier);
	}
	/**
	 * Retrieve a user by their unique identifier and "remember me" token.
	 *
	 * @param  mixed  $identifier
	 * @param  string  $token
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByToken($identifier, $token)
	{
		$model = $this->retrieveById($identifer);
		
		if ( $model->getRememberToken() == $token ) return $model;
		else return null;
		
		/*
		$model = $this->createModel();
		return $model->newQuery()
                        ->where($model->getKeyName(), $identifier)
                        ->where($model->getRememberTokenName(), $token)
                        ->first();
  *.
  */
	}
	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  string  $token
	 * @return void
	 */
	public function updateRememberToken(UserInterface $user, $token)
	{
		$user->setRememberToken($token);
		$user->save();
	}
	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		// First we will add each credential element to the query as a where clause.
		// Then we can execute the query and, if we found a user, return it in a
		// Eloquent User "model" that will be utilized by the Guard instances.
		$keys = array();
		$values = array();
		foreach ($credentials as $key => $value)
		{
			if ( ! str_contains($key, 'password') ) {
			 array_push($keys,$key);
			 array_push($values,$value);
			}
			
		}
		return $this->findBy($keys,$values);
	}
	
	public function findBy($keys,$values) {
		$user = null;
		foreach ($this->db->getKeys() as $key) {
		 $user = $this->db->get($key);
		 $keysMatch = true;
		 $foundUser = null;
		 
		 if (is_array($keys)) {
			 
			 for ($i=0;$i<count($keys);$i++) {
			  if ($user[$keys[$i]] !== $values[$i]) {
				  $keysMatch = false;
				  break;
			  }
			 }
			 
			}
			else {
				 if ($user[$keys] !== $values) $keysMatch = false;
			}
			 
			if ($keysMatch) {
			  $foundUser = $key;
			  break;
			}
		
		}
		
		if ( $foundUser == null ) $user = null;
		else $user = $this->createModel($this->db,$foundUser);
		return $user;
	}
	
	
	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials)
	{
		$plain = $credentials['password'];
		$valid = $this->hasher->check($plain, $user->getAuthPassword());
		
		/*
		echo 'plain: ' . $plain . "<br />";
		echo 'hashed: ' . $user->getAuthPassword() . "<br />";
		echo 'valid: ' . $valid;
		
		die();
		*/
		
		return $valid;
	}
	/**
	 * Create a new instance of the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function createModel(FlintstoneDB $db, $key)
	{
		//$class = '\\'.ltrim($this->model, '\\');
		//$class = $this->model;
		return new LaravelFlintstoneUser($db, $key);
	}
}


	
	