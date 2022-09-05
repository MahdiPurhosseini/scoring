<?php

    namespace App\Listeners;

    use App\Events\EventNotification;
    use App\Repository\Api\Eloquent\NotificationRepository;

    class SendNotification
    {
        /**
         * Create the event listener.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }

        /**
         * Handle the event.
         *
         * @param EventNotification $event
         * @return void
         */
        public function handle( EventNotification $event )
        {
            $notificationClass = new NotificationRepository();
            $notificationClass->sendPush( $event->user->id , $event->message , $event->content );
        }
    }
