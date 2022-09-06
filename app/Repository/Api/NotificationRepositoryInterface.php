<?php

    namespace App\Repository\Api;

    use Ladumor\OneSignal\OneSignal;

    interface NotificationRepositoryInterface
    {

        /**
         * @param $user_id
         * @param $message
         * @param array $content
         */
        public function sendPush( $user_id , $message , array $content = [] );

        public function getNotifications();

        /**
         * @param $notificationId
         */
        public function getNotification($notificationId);

        public function getDevices();

        /**
         * @param $deviceId
         */
        public function getDevice( $deviceId );

    }
