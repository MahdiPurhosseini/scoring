<?php


namespace App\Helper;


class SendSms
{

    protected $sendWith;

    public function __construct($sendWith)
    {
        if (is_null($sendWith)) {
            die('apiKey is empty');
            exit;
        }
        $this->sendWith = trim($sendWith);
    }

    public function verifyLookup($receptor, $token, $type = null)
    {
        if($this->sendWith == 'kavenegar'){
            $api = new Kavenegar(config('app.sms.kavenegar.apipath'));
            $result = $api->VerifyLookup($receptor, $token, config('app.sms.kavenegar.pattern.register'), $type);
        }
        return $result;
    }


}
