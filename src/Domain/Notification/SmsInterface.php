<?php

namespace App\Domain\Notification;

/**
 * Interface SmsInterface
 * @package App\Domain\Notification
 */
interface SmsInterface
{
    /**
     * @return string
     */
    public function getText(): string;
}