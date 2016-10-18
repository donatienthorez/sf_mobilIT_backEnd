<?php

namespace MainBundle\Controller\Api;

use MainBundle\Entity\Notification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use MainBundle\Controller\Api\Base\BaseController;
use MainBundle\Entity\Section;

/**
 * @FosRest\NamePrefix("api_notifications_")
 */
class NotificationController extends BaseController
{
    /**
     * @FosRest\View()
     *
     * @Security("has_role('ROLE_USER')")
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
     *     nullable=false,
     *     default=null,
     *     description="Esn section of the notification"
     * )
     * @QueryParam(
     *     name="type",
     *     nullable=false,
     *     default=null,
     *     description="Type of the notification"
     * )
     * @QueryParam(
     *     name="link",
     *     nullable=true,
     *     default=null,
     *     description="Link of the notification"
     * )
     * @param ParamFetcher $paramFetcher
     *
     * @return array|Response
     *
     * @Security("has_role('ROLE_BOARD')")
     */
    public function sendAction(ParamFetcher $paramFetcher)
    {
        $title = $paramFetcher->get('title');
        $content = $paramFetcher->get('content');
        $sections = $paramFetcher->get('sections');
        $type = sprintf("%s-%s", Notification::NOTIFICATION_TYPE_BACK_OFFICE, $paramFetcher->get('type'));
        $link = $paramFetcher->get('link');

        if (!$title || !$content || !$type) {
            return new Response("Invalid post arguments", Response::HTTP_BAD_REQUEST);
        }

        if (!$sections) {
            $sections = array();
            array_push($sections, $this->getUser()->getSection()->getCodeSection());
        }

        $notification =
            $this
                ->get('main.notification.service')
                ->sendNotifications($title, $content, $this->getUser(), $sections, $type, $link);

        return [
            "title" => $notification->getTitle(),
            "content" => $notification->getContent(),
            "sent_at" => $notification->getSentAt()
        ];
    }


    /**
     * @FosRest\View()
     * @FosRest\Post("{section}/sendFromDrupal")
     * @ParamConverter("section", class="MainBundle:Section", options={"codeSection" = "section"})
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
     *     name="token",
     *     nullable=false,
     *     description="Token of the section"
     * )
     * @QueryParam(
     *     name="type",
     *     nullable=false,
     *     description="Type of the notification"
     * )
     * @param Section $section
     * @param Request $request
     *
     * @return array|BadRequestHttpException
     */
    public function sendFromDrupalAction(Section $section, Request $request)
    {
        $title = $request->request->get('title');
        $content = $request->request->get('content');
        $token = $request->request->get('token');
        $type = sprintf("%s-%s", Notification::NOTIFICATION_TYPE_DRUPAL, $request->request->get('type'));

        if (!$title || !$content || !$token || !$type) {
            return new Response("Invalid post arguments", Response::HTTP_BAD_REQUEST);
        }

        if (!$this
            ->get('main.section.fetcher')
            ->checkSectionToken($section, $token)) {
            return new Response("Invalid token or section", Response::HTTP_FORBIDDEN);
        }

        return $this
            ->get('main.notification.service')
            ->sendNotification($title, $content, $section, $type);
    }

    public function countAction()
    {
        return $this
            ->get('main.notification.fetcher')
            ->count();
    }
}
