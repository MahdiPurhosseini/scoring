<?php

    namespace App\Events;

    use Illuminate\Broadcasting\Channel;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Broadcasting\InteractsWithSockets;

    class EventNotification
    {
        use Dispatchable , InteractsWithSockets , SerializesModels;

        public $user;
        public $message;
        public $content;

        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct( $user , $message , $content = [] )
        {
            $this->user = $user;
            $this->message = $message;
            $this->content = $content;
        }

        /**
         * Get the channels the event should broadcast on.
         * @return Channel|PrivateChannel
         */
        public function broadcastOn(): Channel|PrivateChannel
        {
            return new PrivateChannel( 'channel-name' );
        }
    }
