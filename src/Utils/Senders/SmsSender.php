<?php

namespace App\Utils\Senders;

use App\Domain\Notification\SmsInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Dummy sms message sender, write sms to the log file
 *
 * @package App\Utils\Senders
 */
class SmsSender implements SmsSenderInterface
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * SmsSender constructor.
     * @param string $phone
     * @throws \Exception
     */
    public function __construct(string $phone)
    {
        $this->phone = $phone;
        $this->logger = new Logger('smslog');
        $this->logger->pushHandler(new StreamHandler('./sms-api.txt'));
    }

    /**
     * @param SmsInterface $sms
     */
    public function send(SmsInterface $sms): void
    {
        $this->logger->info('Send SMS to: ' . $this->phone . ' Message: ' . $sms->getText());
    }
}