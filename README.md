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
