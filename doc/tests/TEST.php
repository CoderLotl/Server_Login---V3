<?php

require __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;


//---------------------------

$datos = ['nombre' => 'pepe'];
$secretWord = '$SPL4B0$';

$now = time();
$payload = array(
    'data' => $datos,
    'app' => "TP Comanda",    
);

$token =  JWT::encode($payload, $secretWord);

echo 'Encoded: ' . $token . "\n";

/*
try
{
    $decoded = JWT::decode($token, $secretWord, array('HS256'));

    echo 'Decoded: ';
    var_dump($decoded);
}
catch(Exception $e)
{
    echo $e->getMessage();
}*/