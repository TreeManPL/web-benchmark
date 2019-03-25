<?php

namespace App\Utils\Senders;

use App\Domain\Notification\SmsInterface;

/**
 * Interface SmsSenderInterface
 * @package App\Utils\Senders
 */
interface SmsSenderInterface {
    /**
     * @param SmsInterface $sms
     * @return mixed
     */
    public function send(SmsInterface $sms);
}