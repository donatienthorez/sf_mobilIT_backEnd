<?php

namespace MainBundle\Controller\Api;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use MainBundle\Controller\Api\Base\BaseController;
use MainBundle\Security\Voter\SectionVoter;

/**
 * @FosRest\NamePrefix("api_notifications_")
 */
class NotificationController extends BaseController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @FosRest\View()
     */
    public function listAction()
    {
        $section = $this->getUser()->getSection();

        $this->checkPermissionsForSection($section);

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
     * @param ParamFetcher $paramFetcher
     * @return array|HttpInvalidParamException
     */
    public function sendAction(ParamFetcher $paramFetcher)
    {
        $title = $paramFetcher->get('title');
        $content = $paramFetcher->get('content');
        $sections = $paramFetcher->get('sections');

        if (!$title || !$content) {
           return new HttpInvalidParamException();
        }

        if (!$sections) {
            $sections = array();
            array_push($sections, $this->getUser()->getSection()->getCodeSection());
        }

        $notification =
            $this
                ->get('main.notification.service')
                ->send($title, $content, $this->getUser(), $sections);

        return [
            "title" => $notification->getTitle(),
            "content" => $notification->getContent(),
            "sent_at" => $notification->getSentAt()
        ];
    }

    public function countAction()
    {
        return $this
            ->get('main.notification.fetcher')
            ->count();
    }
}
