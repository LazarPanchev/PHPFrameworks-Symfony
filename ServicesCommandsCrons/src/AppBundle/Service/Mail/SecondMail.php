<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 11:17
 */

namespace AppBundle\Service\Mail;


class SecondMail implements MailInterface
{

    public function send(string $input)
    {
        echo $input . " Hello from my second mail implementation.";
    }
}