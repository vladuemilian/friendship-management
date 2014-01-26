friendship-management
=====================

#### Package description

A laravel package which provides a "friendship" management between 
two entities. The relationship is called "friendship" in this package
, but you can use this plugin to manage any relationship between 
two entities.

#### Installation

The package have implementation only for Laravel 4 framework.

 * Run database migration:

`php artisan --bench=softservlet\friendship`

 * Add the provider into app/config/app.php array, at the 'providers' index

`'Softservlet\Friendship\Laravel\Providers\LaravelFriendshipServiceProvider'`

 * Define the entities. 
 
 The package give you the responsability to create the
 entity object. The next example will ilustrate you how to create a friendship
 between an object defined in your application in `App\User\User`

 Your object must implements FriendableInterface, so you may have the following
 class into App\User.

 ```php
 <?php namespace App\User;

 use Softservlet\Friendship\Core\FriendableInterface;

 class User implements FriendableInterface
 {
	//your User implementation here
 }
 ```
 * Configure the service provider

 Since the package gives you opportunity to define your own entities, the 
 service provider needs to know about those entities, so let's edit it.
 In the above example, we defined our entity in App\User\User, open 
 `softservlet/friendship/src/Softservlet/Friendship/Laravel/Providers/LaravelFriendshipServiceProvider`
 and replace:

 `$this->app->bind('Softservlet\Friendship\Core\FriendableInterface', 'Friends\User\User');`

 with:

 `$this->app->bind('Softservlet\Friendship\Core\FriendableInterface', 'App\User\User');`
 
#### How to use

 We define bellow a sample about how to use in Laravel context:

 Let's write some code to see how to make a friendship connection
 between two entities.

 ```php
 <?php 

 class FriendshipController extends BaseController
 {
 	public function __construct(FriendableInterface $friendable)
	{
		$this->friendable = $friendable;
	}
 	
	public function createFriendship()
	{
		$actor = $this->friendable->find(1); //the friendable object with id 1
		$user = $this->friendable->find(2); 

		//create a instance of Friendship object
		$friendship = App::make('Softservlet\Friendship\Core\FriendshipInterface', array('actor' =>$actor, 'user'=> $user));

		//actor sends a friendship request to user
		$friendship->send();
	}

	public function acceptFriendship()
	{
		//define actor and user friendable objects

		//create a friendable object

		$friendship->accept();
	}
 }
```


#### Documentation

Friendship Object

Assumming that $friendship is a instance like we did above, with $actor and $user as parameters
we have:
 * `$friendship->send()` - sends a friendship request from $actor to $user
 * `$friendship->accept()` - the $actor will accept the friendship of $user(if exists one)
 * `$friendship->deny()` - the $actor will deny the friendship of $user(if exists one) 
 * `$friendship->delete()` - the $actor will delete the connection with $user(if exists one)
 * `$friendship->exists($status)` - return boolean if friendship exists between the $actor and
 the $user. the $status parameter represents the friendship status defined in FriendshipEloquent
