<?php

namespace App\Utils\Notifications;

use App\Domain\Notification\EmailNotification;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\LoadTimeDataProviderInterface;
use App\Utils\Senders\EmailSenderInterface;


class SlowLoadNotificator implements NotificatorInterface {
    /**
     * @var LoadTimeDataProviderInterface
     */
    private $loadTimeDataProvider;

    /**
     * @var EmailSenderInterface
     */
    private $emailSender;

    /**
     * SlowLoadNotificator constructor.
     * @param LoadTimeDataProviderInterface $loadTimeDataProvider
     * @param EmailSenderInterface $emailSender
     */
    public function __construct(LoadTimeDataProviderInterface $loadTimeDataProvider, EmailSenderInterface $emailSender)
    {
        $this->loadTimeDataProvider = $loadTimeDataProvider;
        $this->emailSender = $emailSender;
    }

    /**
     * @param Url $reference
     * @param Urls $compare
     */
    public function notify(Url $reference, Urls $compare): void
    {

        if ($this->isConditionsMet($reference, $compare))
        {
            $email = new EmailNotification(
                'Your website load slow then others',
                'Your website load slow then others'
            );
            $this->emailSender->send($email);
        }
    }

    /**
     * @param Url $reference
     * @param Urls $compare
     * @return bool
     */
    private function isConditionsMet(Url $reference, Urls $compare): bool
    {
        $refLoadTime =  $this->loadTimeDataProvider->getLoadTime($reference);

        if ($refLoadTime === null) {
            return false;
        }

        foreach ($compare->getUrls() as $url) {
            $urlLoadTime = $this->loadTimeDataProvider->getLoadTime($url);

            if ($urlLoadTime !== null && ($urlLoadTime - $refLoadTime) <0 ) {
                return true;
            }
        }
        return false;
    }


}