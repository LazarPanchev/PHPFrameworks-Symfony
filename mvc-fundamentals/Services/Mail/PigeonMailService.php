<?php

namespace Services\Mail;


class PigeonMailService implements MailServiceInterface
{

    public function sendMail()
    {
        echo "Send long flying mail via a pigeon :) . <br/>";
    }
}