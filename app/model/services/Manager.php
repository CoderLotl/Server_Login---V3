<?php

namespace Model\Services;

use Exception;
use Model\Services\AuthJWT;
use Model\Utilities\Log;
use Model\Services\DataAccess;
use Model\Services\Mailer;
use Model\Utilities\CodeGenerator;

class Manager
{
    // - - - - - - - - - - - - - PUBLIC FUNCTIONS

    public static function Login($request, $response)
    {
        try
        {
            $params = self::GetRequest($request);
            $password = $params['password'];            
            $user = DataAccess::SelectWhere('users', ['user'], [$params['user']]);            
            $payload = '';
            
            if(!$user) {
                return self::ReturnResponse($request, $response, 'Invalid user or password.', 400);
            }

            $user = $user[0];

            if(!password_verify($password, $user['password']) // We check if the password is right.
            {
                return self::ReturnResponse($request, $response, 'Invalid password.', 400);
            }

            if(!$user['verified'] == 1) // We check if the user is a verified account.
            {
                return self::ReturnResponse($request, $response, 'The account has not been verified their account yet.', 400);
            }

            // We create the token
            $jwt = AuthJWT::NewToken($params['user']);
            $expireTime = time() + 3600;                   

            $payload = json_encode(['token' => $jwt]);

            $response->getBody()->write(json_encode(['response' => $payload]));
            return $response->withHeader('Set-Cookie',
            "token=$jwt; Path=/; Expires=" . gmdate('D, d M Y H:i:s T', $expireTime) . "; HttpOnly; Secure; SameSite=Strict");
            
        }
        catch(Exception $e)
        {
            Log::WriteLog('req_error.txt', $e->getMessage());
        }
    }

    public static function Logout($request, $response)
    {
        Log::WriteLog('asd.txt', 'asd');
        return $response->withHeader('Set-Cookie',
        "token=deleted; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT; HttpOnly; Secure; SameSite=Strict"); 
    }

    public static function ReturnToFront($request, $response)
    {
        $payload = file_get_contents('./client/dist/index.html');
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public static function Register($request, $response)
    {
        $params = self::GetRequest($request);
        $user = $params['user'];
        $mail = $params['mail'];
        $password = $params['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if(DataAccess::SelectWhere('users', ['mail'], [$mail], ['mail']))
        {
            return self::ReturnResponse($request, $response, 'This mail is already in use.', 400);
        }
        if(DataAccess::SelectWhere('users', ['user'], [$user], ['user']))
        {
            return self::ReturnResponse($request, $response, 'This username is already registered.', 400);
        }

        // - - - - - [ POST-CHECKING ]
        
        $mailer = new Mailer();
        $validVlink = false;
        do
        {            
            $vlink = CodeGenerator::RandomAlphaNumCode(10);
            if(!DataAccess::SelectWhere('users', ['vlink'], [$vlink]))
            {
                $validVlink == true;
            }
        }while($validVlink == false);

        DataAccess::Insert('users', ['user', 'password', 'verified', 'mail', 'vlink'], [$user, $hashedPassword, 0, $mail, $vlink]);

        $mailer->SendMail($user, $mail, 'Registration', 'Hello, mail!', true);

        return self::ReturnResponse($request, $response, 'Registration successful!', 200);
    }

    public static function Verify($request, $response)
    {
        $params = self::GetRequest($request);
        $code = $params['code'];

        if(strlen($code) != 10)
        {
            return self::ReturnResponse($request, $response, "The provided code is not valid.", 400);
        }
        
        $vLinkUser = DataAccess::SelectWhere('users', ['vlink'], [$code]);        

        if(!$vLinkUser)
        {
            return self::ReturnResponse($request, $response, "The entried code doesn't exist.", 400);
        }

        $vLinkUser = $vLinkUser[0];
        if($vLinkUser['verified'] == 1)
        {
            return self::ReturnResponse($request, $response, "That account has already been verified.", 400);
        }
        
        DataAccess::Update('users', ['verified'], [1], 'vlink', $vLinkUser['vlink']);
        return self::ReturnResponse($request, $response, 'Account verified! You can now log in.', 200);
    }

    // - - - - - - - - - - - - - PRIVATE FUNCTIONS

    private static function GetRequest($request)
    {        
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'DELETE')
        {
            $params = $request->getQueryParams();
        }
        else
        {
            $params = $request->getParsedBody();
        }        
        
        return $params;
    }

    private static function ReturnResponse($request, $response, $payload, $status = 200)
    {        
        $response->getBody()->write(json_encode(['response' => $payload]));        
        return $response->withStatus($status);
    }

    private static function Redirect($request, $response, $page, $code)
    {
        return $response->withHeader('Location', "/{$page}")->withStatus($code);
    }
}
