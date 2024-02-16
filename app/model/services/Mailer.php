<?php
namespace Model\Services;

use PHPMailer\PHPMailer\PHPMailer;
use Model\Utilities\Log;
use Exception;

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    public function SendMail(string $receiver, string $to, string $subject, string $body, bool $loadConfig = false,
                                string $smtp = null, string $username = null, string $password = null, string $from = null,
                                string $sender = null)
    {
        try
        {
            $this->mailer->isSMTP();                        // Send using SMTP

            if($loadConfig == false)
            {
                // Server settings
                $this->mailer->Host       = $smtp;          // SMTP server
                $this->mailer->Username   = $username;      // SMTP username
                $this->mailer->Password   = $password;      // SMTP password
                $this->mailer->setFrom($from, $sender);
            }
            else
            {
                $this->mailer->Host       = SMTP_HOST;          // SMTP server
                $this->mailer->Username   = SMTP_USERNAME;      // SMTP username
                $this->mailer->Password   = SMTP_PASSWORD;      // SMTP password
                $this->mailer->setFrom(SMTP_FROM, SMTP_SENDER);
            }
            
            $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mailer->Port       = 587;                                    // TCP port to connect to
        
            // Recipients
            $this->mailer->addAddress($to, $receiver);     // Add a recipient
        
            // Content
            $this->mailer->isHTML(true);                                        // Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
        
            // Send the email
            $this->mailer->send();            
        }
        catch(Exception $e)
        {            
            Log::WriteLog('mail_errors.txt', "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }
}
?>