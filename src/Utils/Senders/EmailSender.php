<?php

namespace App\Utils\Senders;

use App\Domain\Notification\EmailInterface;

/**
 * Class EmailSender
 * @package App\Utils\Senders
 */
class EmailSender implements EmailSenderInterface {
    /**
     * @var string
     */
    private $email;

    /**
     * EmailSender constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param EmailInterface $email
     */
    public function send(EmailInterface $email): void
    {
        mail($this->email, $email->getSubject(), $email->getMessage());
    }
}