<?php

namespace MainBundle\Service;

use MainBundle\Entity\Section;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use MainBundle\Security\Voter\SectionVoter;
use MainBundle\Adapter\RegIdAdapter;
use MainBundle\Creator\NotificationCreator;
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
     * @var AuthorizationCheckerInterface
     */
    protected $securityContext;

    /**
     * @param NotificationManager $notificationManager
     * @param SectionFetcher $sectionFetcher
     * @param NotificationCreator $notificationCreator
     * @param NotificationHelper $notificationHelper
     * @param RegIdAdapter $regIdAdapter
     * @param AuthorizationCheckerInterface $securityContext
     */
    public function __construct(
        NotificationManager $notificationManager,
        SectionFetcher $sectionFetcher,
        NotificationCreator $notificationCreator,
        NotificationHelper $notificationHelper,
        RegIdAdapter $regIdAdapter,
        AuthorizationCheckerInterface $securityContext
    ) {
        $this->notificationManager = $notificationManager;
        $this->sectionFetcher      = $sectionFetcher;
        $this->notificationCreator = $notificationCreator;
        $this->notificationHelper  = $notificationHelper;
        $this->regIdAdapter        = $regIdAdapter;
        $this->securityContext = $securityContext;
    }

    public function send($title, $content, $user, $sections)
    {
        foreach ($sections as $section) {
            $section = $this
                ->sectionFetcher
                ->getSection($section);

            if (!$this->securityContext->isGranted(SectionVoter::ACCESS, $section)) {
                throw new AccessDeniedHttpException(
                    "Only admins can send notifications to others sections than theirs."
                );
            }

            $notification = $this
                ->notificationCreator
                ->createNotification(
                    $title,
                    $content,
                    $user,
                    $section
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

        return $notification;
    }
    public function sendFromDrupal($title, $content, Section $section, $token)
    {
        $notification = $this
            ->notificationCreator
            ->createNotification(
                $title,
                $content,
                null,
                $section
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
