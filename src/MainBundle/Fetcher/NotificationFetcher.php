<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;

class NotificationFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getNotifications($section)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Notification')
            ->findBy(
                array('section' => $section),
                array('sendAt' => 'DESC'),
                10
            );
    }

    public function count()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Notification')
            ->count();
    }
}
