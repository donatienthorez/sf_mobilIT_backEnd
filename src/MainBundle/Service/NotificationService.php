<?php

namespace MainBundle\Service;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use MainBundle\Adapter\RegIdAdapter;
use MainBundle\Creator\NotificationCreator;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Section;
use MainBundle\Entity\User;
use MainBundle\Fetcher\RegIdFetcher;
use MainBundle\Fetcher\SectionFetcher;
use MainBundle\Helper\NotificationHelper;
use MainBundle\Manager\NotificationManager;
use MainBundle\Security\Voter\SectionVoter;

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

    /**
     * Send notifications to sections
     *
     * @param string $title
     * @param string $content
     * @param User $user
     * @param array $sections
     *
     * @return Notification|null
     */
    public function sendNotifications($title, $content, User $user, array $sections)
    {
        $notification = null;
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
                ->sendNotification(
                    $title,
                    $content,
                    $section,
                    null,
                    $user
                );
        }

        return $notification;
    }

    /**
     * Send a notification.
     *
     * @param string $title
     * @param string $content
     * @param Section $section
     * @param string $type
     * @param User|null $user
     *
     * @return Notification
     */
    public function sendNotification($title, $content, Section $section, $type, $user = null)
    {
        $notification = $this
            ->notificationCreator
            ->createNotification(
                $title,
                $content,
                $user,
                $section,
                $type
            );

        $regIds = $this
            ->regIdAdapter
            ->getModels($section->getRegIds());

        $this
            ->notificationHelper
            ->sendNotification($notification, $regIds);

        $this
            ->notificationManager
            ->saveNotification($notification);

        return $notification;
    }
}
