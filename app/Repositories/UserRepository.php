<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Auth0\Laravel\{UserRepositoryAbstract, UserRepositoryContract};
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Prompts\Output\ConsoleOutput;


final class UserRepository extends UserRepositoryAbstract implements  UserRepositoryContract
{
    public function fromAccessToken(array $user): ?Authenticatable
    {
        /*
            $user = [ // Example of a decoded access token
                "iss"   => "https://example.auth0.com/",
                "aud"   => "https://api.example.com/calendar/v1/",
                "sub"   => "auth0|123456",
                "exp"   => 1458872196,
                "iat"   => 1458785796,
                "scope" => "read write",
            ];
        */

        return User::where('auth0', $user['sub'])->firstOrFail();
    }

    public function fromSession(array $user): ?Authenticatable
    {
        /*
            $user = [ // Example of a decoded ID token
                "iss"         => "http://example.auth0.com",
                "aud"         => "client_id",
                "sub"         => "auth0|123456",
                "exp"         => 1458872196,
                "iat"         => 1458785796,
                "name"        => "Jane Doe",
                "email"       => "janedoe@example.com",
            ];
        */

        $userdb = User::where('email', $user['email'])->firstOrFail();
        if($userdb != null && $userdb->auth0 == null) {
            $userdb->auth0 = $user['sub'] ?? '';
            $userdb->save();
        }

        return $userdb;
    }

}
