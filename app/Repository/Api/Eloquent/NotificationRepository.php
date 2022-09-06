<?php

    namespace App\Repository\Api\Eloquent;

    use App\Models\UserDevice;
    use App\Repository\Api\NotificationRepositoryInterface;
    use Ladumor\OneSignal\OneSignal;

    class NotificationRepository implements NotificationRepositoryInterface
    {

        public function sendPush( $user_id , $message , array $content = [] )
        {
            $player_ids = UserDevice::where("user_id",$user_id)->pluck("os_player_id")->toArray();
            if ($player_ids != []){
                $fields[ 'include_player_ids' ] = $player_ids;
                $fields[ 'contents' ] = $content;
                OneSignal::sendPush( $fields , $message );
            }
        }

        public function getNotifications()
        {
            return OneSignal::getNotifications();
        }

        public function getNotification( $notificationId )
        {
            return OneSignal::getNotification( $notificationId );
        }

        public function getDevices()
        {
            return OneSignal::getDevices();
        }

        public function getDevice( $deviceId )
        {
            return OneSignal::getDevice( $deviceId );
        }

    }
