<?php

namespace App\Utils\Senders;

use App\Domain\Notification\EmailInterface;

/**
 * Interface EmailSenderInterface
 * @package App\Utils\Senders
 */
interface EmailSenderInterface
{
    /**
     * @param EmailInterface $email
     * @return mixed
     */
    public function send(EmailInterface $email);
}