<?php

namespace MainBundle\Helper;

use MainBundle\Entity\Notification;

class NotificationHelper
{
    /**
     * @param Notification $notification
     * @param array $regIds
     *
     * @return mixed
     */
    public function sendNotification(Notification $notification, $regIds)
    {

        $message = array(
            "m" => $notification->getContent(),
            "sbj" => $notification->getTitle()
        );

        //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $regIds,
            'data' => $message,
        );

        // Update your Google Cloud Messaging API Key
        define("GOOGLE_API_KEY", "AIzaSyARq1v5hjOd16fSBin0DXmG-EX5CeYQS84");
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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
