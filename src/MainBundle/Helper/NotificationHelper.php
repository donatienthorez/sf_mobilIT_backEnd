<?php

namespace MainBundle\Helper;

use Symfony\Component\DependencyInjection\Container;
use MainBundle\Entity\Notification;

class NotificationHelper
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Send the notification on the google android api website.
     *
     * @param Notification $notification
     * @param array $regIds
     *
     * @return mixed
     */
    public function sendNotification(Notification $notification, $regIds)
    {
        $headers = [
            sprintf(
                'Authorization: key=%s',
                $this->container->getParameter('google_api_key')
            ),
            'Content-Type: application/json'];

        $fields = [
            'registration_ids' => $regIds,
            'data' => [
                'content' => $notification->getContent(),
                'title' => $notification->getTitle(),
                'type' => $notification->getType()]
        ];

        $ch = curl_init();
        curl_setopt($ch,
            CURLOPT_URL,
            $this->container->getParameter('google_api_website')
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if (!$result) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }
}
