<?php namespace Cci\LaravelFlintstone;

use Illuminate\Support\ServiceProvider;
use Illuminate\Hashing\BcryptHasher as Hasher;

class LaravelFlintstoneServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	protected $options;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cci/laravel-flintstone');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
		$this->options = array('dir' => storage_path() . '/db/');
		
		$this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('LaravelFlintstone', 'Cci\LaravelFlintstone\Facades\LaravelFlintstone');
		  $loader->alias('LaravelFlintstoneUserprovider', 'Cci\LaravelFlintstone\Facades\LaravelFlintstoneUserprovider');
		});
		
		$this->app['laravelflintstone'] = $this->app->share(function($app)
		{
			return new LaravelFlintstone($this->options);
		});
		
		$this->app['laravelflintstoneuserprovider'] = $this->app->share(function($app)
		{
			return new LaravelFlintstoneUserprovider(new Hasher(), new LaravelFlintstone($this->options));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('laravelflintstone','laravelflintstoneuserprovider');
	}

}
