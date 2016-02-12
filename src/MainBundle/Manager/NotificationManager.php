<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Notification;

class NotificationManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function saveNotification(Notification $notification)
    {
        $this
            ->em
            ->persist($notification);

        $this
            ->em
            ->flush();
    }
}
