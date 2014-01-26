friendship-management
=====================

#### Package description

A laravel package which provides a "friendship" connection between 
two entities. The relationship is called "friendship", but you can
use this plugin to manage any relationship between two entities.

#### Installation

The package have implementation only for Laravel 4 framework.

1. Run database migration:
`php artisan --bench=softservlet\friendship`
2. Add the provider into app/config/app.php
`'Softservlet\Friendship\Laravel\Providers\LaravelFriendshipServiceProvider'`
