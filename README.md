# Sanctum Auth ACL
JWT Auth ACL is a Laravel package to authentication and authorization package.

The middleware `ha.acl` check if auth user is authorized to access the route and he is authorized when has permission with 
the same name of the route within any role he has

## Install
* Install packaqe with composer `composer require juliocosta/lara-auth`
* Publish seeder `php artisan vendor:publish --foce --tag ha-auth-seeds`
* Add `ha.acl` on routes with that you wish check permissions
* Run `php artisan db:seed --class=PermissionsTableSeeder` to populate permissions table
* Run `php artisan jwt:secret`
* Run php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
* Run php artisan migrate


## Use
* Add `has.acl` on your protected routes
* Publish seeder `php artisan vendor:publish --foce --tag ha-auth-seeds`
* Run `php artisan db:seed --class=PermissionsTableSeeder` to populate permissions table

