<?php

namespace App\Utils;

use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\DataProvidersInterface;
use App\Utils\Notifications\DoubleSlowLoadNotificator;
use App\Utils\Notifications\NotificatorInterface;
use App\Utils\Notifications\SlowLoadNotificator;
use App\Utils\Senders\EmailSenderInterface;
use App\Utils\Senders\SmsSenderInterface;

/**
 * Class NotificationsBuilder
 * @package App\Utils
 */
class NotificationsBuilder {
    /**
     * @var
     */
    private $creators;

    /**
     * NotificationsBuilder constructor.
     * @param DataProvidersInterface $dataProviders
     * @param EmailSenderInterface $emailSender
     * @param SmsSenderInterface $smsSender
     */
    public function __construct(DataProvidersInterface $dataProviders, EmailSenderInterface $emailSender, SmsSenderInterface $smsSender)
    {
        $this
            ->addNotification('slowloadtime', new SlowLoadNotificator($dataProviders->getLoadTimeDataProvider(), $emailSender))
            ->addNotification('doubleslowloadtime', new DoubleSlowLoadNotificator($dataProviders->getLoadTimeDataProvider(), $smsSender))
        ;
    }

    /**
     * @param string $name
     * @param NotificatorInterface $creator
     * @return NotificationsBuilder
     */
    private function addNotification(string $name, NotificatorInterface $creator): NotificationsBuilder
    {
        $this->creators[$name] = $creator;
        return $this;
    }

    /**
     * @param string $name
     * @return NotificatorInterface|null
     */
    private function get(string $name): ?NotificatorInterface
    {
        return $this->creators[$name] ?? null;
    }

    /**
     * @param array $notifications
     * @param Url $referenceUrl
     * @param Urls $compareToUrls
     */
    public function notify(array $notifications, Url $referenceUrl, Urls $compareToUrls): void
    {
        foreach ($notifications as $notification) {
            $notificator = $this->get($notification);
            if ($notificator !== null){
                $notificator->notify($referenceUrl, $compareToUrls);
            }
        }
    }
}