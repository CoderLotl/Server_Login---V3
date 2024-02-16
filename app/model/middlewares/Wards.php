<?php

namespace Model\Middlewares;
use Model\Services\AuthJWT;
use Model\Utilities\Log;
use Slim\Routing\RouteContext;

class Wards
{
    /**
     * Used only at the initial GET {[/]}. Checks if the user is already logged.
     * Redirects the user to the /home.
     */
    public static function AlreadyLoggedLogin($request, $handler)
    {
        $cookies = $request->getCookieParams();
        if(isset($cookies['token']))
        {
            $token = $cookies['token'];
            if(AuthJWT::VerifyToken($token))
            {
                $response = $handler->handle($request);
                return $response->withHeader('Location', '/home')->withStatus(302);
            }
        }
        else
        {
            return $handler->handle($request);
        }
    }

    /**
     * Used for checking if the user is logged.
     * If the user is logged allows them to continue. Else, redirects the user to /error,
     * which is caught by the route catcher at the index and works together with the front which
     * manages the error.
     */
    public static function Auth($request, $handler)
    {
        $cookies = $request->getCookieParams();
        if(isset($cookies['token']))
        {
            $token = $cookies['token'];
            if(AuthJWT::VerifyToken($token))
            {
                return $handler->handle($request);
            }
        }
        else
        {
            $response = $handler->handle($request);
            return $response->withHeader('Location', '/error')->withStatus(302);
        }
    }

    public static function VerifyCode($request, $handler) // UNUSED
    {
        $routeContext = RouteContext::fromRequest($request); // I get the Route Context
        $route = $routeContext->getRoute(); // I geth the Route
        $code = $route->getArgument('code') ?? null; // I get a specific Arg        
    }
}