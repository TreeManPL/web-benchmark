<?php

namespace App\Utils\Notifications;

use App\Domain\Notification\SmsNotification;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\LoadTimeDataProviderInterface;
use App\Utils\Senders\SmsSenderInterface;

/**
 * Class DoubleSlowLoadNotificator
 * @package App\Utils\Notifications
 */
class DoubleSlowLoadNotificator implements NotificatorInterface {

    /**
     * @var LoadTimeDataProviderInterface
     */
    private $loadTimeDataProvider;

    /**
     * @var SmsSenderInterface
     */
    private $smsSender;

    /**
     * DoubleSlowLoadNotificator constructor.
     * @param LoadTimeDataProviderInterface $loadTimeDataProvider
     * @param SmsSenderInterface $smsSender
     */
    public function __construct(LoadTimeDataProviderInterface $loadTimeDataProvider, SmsSenderInterface $smsSender)
    {
        $this->loadTimeDataProvider = $loadTimeDataProvider;
        $this->smsSender = $smsSender;
    }

    /**
     * @param Url $reference
     * @param Urls $compare
     */
    public function notify(Url $reference, Urls $compare): void
    {
        if ($this->isConditionsMet($reference, $compare))
        {
            $sms = new SmsNotification('Your website load double slow then other');
            $this->smsSender->send($sms);
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

            if ($urlLoadTime !== null && ((2*$urlLoadTime) - $refLoadTime) <0 ) {
                return true;
            }
        }
        return false;
    }
}