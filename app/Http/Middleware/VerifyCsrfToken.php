<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/*'
    ];

    /*
    DB_DATABASE=u302286552_pumaBD
    DB_USERNAME=u302286552_UserPuma
    DB_PASSWORD=V1ggcQv6nn+t
    */
}
