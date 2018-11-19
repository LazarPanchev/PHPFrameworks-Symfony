<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 13.11.2018 г.
 * Time: 16:08
 */

namespace Services\Mail;


class SmtpMailService implements MailServiceInterface
{

    public function sendMail()
    {
        echo "SMTP Mail service resolved . <br/>";
    }
}