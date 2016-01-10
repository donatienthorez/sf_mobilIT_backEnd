<?php

namespace MainBundle\Controller\Api;


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
     *     name="section",
     *     nullable=true,
     *     default=null,
     *     description="Esn section of the notification"
     * )
     *
     */
    public function sendAction(ParamFetcher $paramFetcher)
    {
        $title   = $paramFetcher->get('title');
        $content = $paramFetcher->get('content');
        $section = $paramFetcher->get('section');

        var_dump($title);
        var_dump($content);
        var_dump($section);
        die;

        return $data->test;
    }
}
