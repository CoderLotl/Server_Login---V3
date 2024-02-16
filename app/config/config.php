<?php
use Model\Services\DataAccess;
use Model\Utilities\Log;

define('APP_ROOT', dirname(dirname(__FILE__)));
define('DB', APP_ROOT . '/db/db.sqlite');
define('ERRORS', APP_ROOT . '/errors');

DataAccess::$pdo = new PDO('sqlite:' . DB);
DataAccess::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// - - - - - [ SMTP ]

$smtpFile = APP_ROOT . '/config/smtp.json';
if(file_exists($smtpFile))
{
    $smtpData = json_decode(file_get_contents($smtpFile), true);
    define('SMTP_HOST', $smtpData['SMTP_HOST']);
    define('SMTP_USERNAME', $smtpData['SMTP_USERNAME']);
    define('SMTP_PASSWORD', $smtpData['SMTP_PASSWORD']);
    define('SMTP_FROM', $smtpData['SMTP_FROM']);
    define('SMTP_SENDER', $smtpData['SMTP_SENDER']);        
}
else
{
    define('SMTP_HOST', 'asd');
    define('SMTP_USERNAME', 'asd');
    define('SMTP_PASSWORD', 'asd');
    define('SMTP_FROM', 'asd');
    define('SMTP_SENDER', 'asd');
}


?>