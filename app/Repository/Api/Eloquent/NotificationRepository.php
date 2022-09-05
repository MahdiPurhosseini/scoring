<?php

    namespace App\Repository\Api\Eloquent;

    use App\Repository\Api\NotificationRepositoryInterface;
    use Ladumor\OneSignal\OneSignal;

    class NotificationRepository implements NotificationRepositoryInterface
    {

        public function sendPush( $player_id , $message , array $content = [] )
        {
            $fields[ 'include_player_ids' ] = [ $player_id ];
            $fields['contents'] = $content;
            OneSignal::sendPush( $fields , $message );
        }

        public function getNotifications(): OneSignal
        {
            return OneSignal::getNotifications();
        }

        public function getNotification($notificationId): OneSignal
        {
            return OneSignal::getNotification($notificationId);
        }

        public function getDevices(): OneSignal
        {
            return OneSignal::getDevices();
        }

        public function getDevice($deviceId): OneSignal
        {
            return OneSignal::getDevice($deviceId);
        }

    }
