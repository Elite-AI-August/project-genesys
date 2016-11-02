<?php
namespace Caffeinated\Menus;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerServices();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['menu'];
	}

	/**
	 * Register the package services.
	 *
	 * @return void
	 */
	protected function registerServices()
	{
		// Register the Laravel Collective HTML Service Provider
		$this->app->register('Collective\Html\HtmlServiceProvider');

		// Bind our Menu class to the IoC container
		$this->app->bindShared('menu', function($app) {
			return new Menu($app['config'], $app['view'], $app['html'], $app['url']);
		});
	}
}
