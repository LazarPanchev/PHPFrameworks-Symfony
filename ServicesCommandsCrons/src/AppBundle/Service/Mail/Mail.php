<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 11:10
 */

namespace AppBundle\Service\Mail;


class Mail implements MailInterface
{

    public function send(string $input)
    {
        echo $input . " From my first mail service implementation";
    }
}