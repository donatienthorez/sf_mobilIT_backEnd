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
use Symfony\Component\HttpFoundation\Response;

/**
 * @FosRest\NamePrefix("api_notifications_")
 */
class NotificationController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @FosRest\View()
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
     * @Security("has_role('ROLE_USER')")
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
        $title = $paramFetcher->get('title');
        $content = $paramFetcher->get('content');
        $sections = $paramFetcher->get('sections');

        $this
            ->get('main.notification.service')
            ->send($title, $content, $this->getUser(), $sections);

        return array("title" => $title, "content" => $content);
    }

    public function countAction()
    {

        return
            $this
                ->get('main.notification.fetcher')
                ->count();
    }
}
