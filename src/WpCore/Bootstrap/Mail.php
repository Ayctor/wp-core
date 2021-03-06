<?php

namespace WpCore\Bootstrap;

use \PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mail for smtp parameters
 */
class Mail
{
    /**
     * Actions and filters to edit smtp parameters
     */
    public function __construct()
    {
        add_action('phpmailer_init', [$this, 'smptCredentials']);
        add_filter('wp_mail_from', [$this, 'setMailFromAddress']);
        add_filter('wp_mail_from_name', [$this, 'setMailFromName']);
    }

    /**
     * Edit smtp parameters
     * @param  PHPMailer $mail PHPMailer instance
     * @return PHPMailer       Edited PHPMailer instance
     */
    public function smptCredentials(PHPMailer $mail)
    {
        $mail->IsSMTP();
        $mail->SMTPAuth = config('mail.username') && config('mail.password');

        $mail->Host = config('mail.host');
        $mail->Port = config('mail.port');
        $mail->Username = config('mail.username');
        $mail->Password = config('mail.password');

        return $mail;
    }

    /**
     * Set mail from address
     */
    public function setMailFromAddress()
    {
        return config('mail.from.address');
    }

    /**
     * Set mail from name
     */
    public function setMailFromName()
    {
        return config('mail.from.address');
    }
}
