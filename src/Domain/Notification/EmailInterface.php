<?php

namespace App\Domain\Notification;

/**
 * Interface EmailInterface
 * @package App\Domain\Notification
 */
interface EmailInterface {
    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return string
     */
    public function getMessage(): string;
}