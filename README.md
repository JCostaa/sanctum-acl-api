# Sanctum Auth ACL
Sacuntum Auth ACL is a Laravel package to authentication and authorization package.

The middleware `has.acl` check if auth user is authorized to access the route and he is authorized when has permission with 
the same name of the route within any role he has

## Install
* Install packaqe with composer `composer require juliocosta/lara-auth`
* Publish seeder `php artisan vendor:publish --foce --tag ha-auth-seeds`
* Add `has.acl` on routes with that you wish check permissions
* Run php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
* Run php artisan migrate
* Run `php artisan db:seed --class=PermissionsTableSeeder` to populate permissions table


## Use
* Add Sanctum's middleware to your api middleware group within your app/Http/Kernel.php file:    
cUrl
```bash
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

'api' => [
    EnsureFrontendRequestsAreStateful::class,
    'throttle:60,1',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```
* Add trait in  User model
```bash
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}
```
* Add `has.acl` on your protected routes
* Publish seeder `php artisan vendor:publish --foce --tag ha-auth-seeds`
* Run `php artisan db:seed --class=PermissionsTableSeeder` to populate permissions table

