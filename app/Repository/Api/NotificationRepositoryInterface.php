<?php

    namespace App\Repository\Api;

    use Ladumor\OneSignal\OneSignal;

    interface NotificationRepositoryInterface
    {

        /**
         * @param $player_id
         * @param $message
         * @param array $content
         */
        public function sendPush( $player_id , $message , array $content = [] );

        /**
         * @return OneSignal
         */
        public function getNotifications(): OneSignal;

        /**
         * @param $notificationId
         * @return OneSignal
         */
        public function getNotification($notificationId): OneSignal;

        /**
         * @return OneSignal
         */
        public function getDevices(): OneSignal;

        /**
         * @param $deviceId
         * @return OneSignal
         */
        public function getDevice( $deviceId ): OneSignal;

    }
