<?php

namespace App\Providers;

require __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            if (!$request->hasHeader('Authorization')) {
                return null;
            }
            $authorizationHeader = $request->header('Authorization');

            $token = str_replace('Bearer ', '', $authorizationHeader);

            $authenticationData = JWT::decode($token, new Key(env('JWT_KEY'), 'HS256'));

            return User::where('email', $authenticationData->email)->first();
        });
    }
}
