<?php

namespace MainBundle\Service;

use MainBundle\Adapter\RegIdAdapter;
use MainBundle\Controller\Front\NotificationController;
use MainBundle\Creator\NotificationCreator;
use MainBundle\Entity\Notification;
use MainBundle\Fetcher\RegIdFetcher;
use MainBundle\Fetcher\SectionFetcher;
use MainBundle\Helper\NotificationHelper;
use MainBundle\Manager\NotificationManager;

class NotificationService
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @var RegIdFetcher
     */
    private $sectionFetcher;

    /**
     * @var NotificationCreator
     */
    private $notificationCreator;
    /**
     * @var NotificationHelper
     */
    private $notificationHelper;
    /**
     * @var RegIdAdapter
     */
    private $regIdAdapter;

    /**
     * @param NotificationManager $notificationManager
     * @param SectionFetcher $sectionFetcher
     * @param NotificationCreator $notificationCreator
     * @param NotificationHelper $notificationHelper
     * @param RegIdAdapter $regIdAdapter
     */
    public function __construct(
        NotificationManager $notificationManager,
        SectionFetcher $sectionFetcher,
        NotificationCreator $notificationCreator,
        NotificationHelper $notificationHelper,
        RegIdAdapter $regIdAdapter
    ) {
        $this->notificationManager = $notificationManager;
        $this->sectionFetcher      = $sectionFetcher;
        $this->notificationCreator = $notificationCreator;
        $this->notificationHelper  = $notificationHelper;
        $this->regIdAdapter        = $regIdAdapter;
    }

    public function send($title, $content, $user, $sections)
    {
        foreach ($sections as $section) {
            $section = $this
                ->sectionFetcher
                ->getSection($section['code_section']);

            $notification = $this
                ->notificationCreator
                ->createNotification(
                    $title,
                    $content,
                    $user,
                    $section->getCodeSection()
                );

            $regIds = $this
                ->regIdAdapter
                ->getModels($section->getRegIds());

            $this
                ->notificationManager
                ->saveNotification($notification);

            $this
                ->notificationHelper
                ->sendNotification($notification, $regIds);
        }
    }
}
