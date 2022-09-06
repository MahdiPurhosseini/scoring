<?php

    use App\Helper\SendSms;

    function getActivationCode(): int
    {
//        return rand( 111111 , 999999 );
        return 111111; // FOR TESTING
    }

    function sendSmsKavenegar($mobile,$activationCode): int
    {
//        $api = new SendSms( 'kavenegar' );
//        return $api->verifyLookup( $mobile , $activationCode );
        return true;//For Test
    }

