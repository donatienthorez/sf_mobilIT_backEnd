<?php

namespace MainBundle\Controller\Api;

use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @FosRest\Prefix("notifications")
 * @FosRest\NamePrefix("api_notifications_")
 */
class NotificationController extends Controller
{
    /**
     * @QueryParam(
     *     name="section",
     *     nullable=true,
     *     default=null,
     *     description="Esn section of the notifications",
     * )
     */
    public function listAction($section = null)
    {
        if ($section == null) {
            $section = $this->getUser()->getCodeSection();
        }
        /** todo else verify if admin */

        return $this
            ->get('main.notification.fetcher')
            ->getNotifications($section);
    }

    /**
     * @FosRest\View()
     * @FosRest\Post("/send")
     *
     * @QueryParam(
     *     name="title",
     *     nullable=false,
     *     description="Title of the notification"
     * )
     * @QueryParam(
     *     name="content",
     *     nullable=false,
     *     description="Content of the notification"
     * )
     * @QueryParam(
     *     name="sections",
     *     nullable=true,
     *     default=null,
     *     description="Esn section of the notification"
     * )
     *
     */
    public function sendAction(ParamFetcher $paramFetcher)
    {
        $sections = $paramFetcher->get('sections');

        foreach ($sections as $section) {
            $notification = $this
                ->get('main.notification.creator')
                ->createNotification(
                    $paramFetcher->get('title'),
                    $paramFetcher->get('content'),
                    $this->getUser(),
                    $section
                );

            $this
                ->get('main.notification.service')
                ->send($notification);
        }

        return $notification;
    }
}
