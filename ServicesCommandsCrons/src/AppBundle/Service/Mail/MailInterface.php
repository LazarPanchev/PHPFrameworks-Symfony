<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 11:09
 */

namespace AppBundle\Service\Mail;


interface MailInterface
{
    public function send(string $input);

}