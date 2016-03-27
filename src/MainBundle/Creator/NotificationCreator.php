<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Notification;
use MainBundle\Entity\Section;
use MainBundle\Entity\User;

class NotificationCreator
{
    /**
     * Create a notification
     *
     * @param string $title
     * @param string $content
     * @param User|null $user
     * @param Section $section
     * @param $type
     *
     * @return Notification
     */
    public function createNotification($title, $content, $user, Section $section, $type = null)
    {
        $notification = (new Notification())
            ->setTitle($title)
            ->setContent($content)
            ->setSection($section);

        if ($user) {
            $notification->setSentBy($user);
        }
        if ($type) {
            $notification->setType($type);
        }

        return $notification;
    }
}
