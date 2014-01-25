<?php namespace Softservlet\Friendship\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Softservlet\Friendship\Core\FriendableInterface;
use Softservlet\Friendship\Laravel\FriendshipEloquent;
use Softservlet\Friendship\Laravel\FriendshipRepositoryEloquent;

/**
 * @author Vladu Emilian Sorin <vladu@softservlet.com>
 *
 * @version 1.0
 */

class LaravelFriendshipServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('softservlet/friendships');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Softservlet\Friendship\Core\FriendableInterface', 'Friends\User\User');

		/**
		 * @param $param[0] - contain the actor 
		 * @param $param[1] - contain the receiver
		 */
		$this->app->bind('Softservlet\Friendship\Core\FriendshipInterface', 
		function($app, $params)
		{
			return new FriendshipEloquent($params['actor'], $params['user']);
		});

		$this->app->bind('Softservlet\Friendship\Core\FriendshipRepositoryInterface', 
		function($app, $params)
		{
			return new FriendshipRepositoryEloquent($params['actor']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
