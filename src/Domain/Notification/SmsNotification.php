<?php

namespace App\Domain\Notification;

/**
 * Class SmsNotification
 * @package App\Domain\Notification
 */
class SmsNotification implements SmsInterface {
    /**
     * @var string
     */
    private $text;

    /**
     * SmsNotification constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}