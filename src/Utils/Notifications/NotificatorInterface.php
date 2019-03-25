<?php

namespace App\Utils\Notifications;

use App\Domain\Url\Url;
use App\Domain\Url\Urls;

/**
 * Interface NotificatorInterface
 * @package App\Utils\Notifications
 */
interface NotificatorInterface {
    /**
     * @param Url $reference
     * @param Urls $compare
     */
    public function notify(Url $reference, Urls $compare): void;
}