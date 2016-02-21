<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Notification;
use MainBundle\Entity\User;

class NotificationCreator
{
    public function createNotification($title, $content, $user, $section)
    {
        $notification = new Notification();
        $notification->setTitle($title);
        $notification->setContent($content);
        $notification->setSection($section);
        if ($user) {
            $notification->setSentBy($user);
        }

        return $notification;
    }
}
