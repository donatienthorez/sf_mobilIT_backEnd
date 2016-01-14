<?php

namespace MainBundle\Service;

use MainBundle\Creator\NotificationCreator;
use MainBundle\Entity\Notification;
use MainBundle\Manager\NotificationManager;

class NotificationService
{

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param NotificationManager $notificationManager
     */
    public function __construct(
        NotificationManager $notificationManager
    ) {
        $this->notificationManager = $notificationManager;
    }

    public function send(Notification $notification)
    {
        $this
            ->notificationManager
            ->saveNotification($notification);

    }
}
