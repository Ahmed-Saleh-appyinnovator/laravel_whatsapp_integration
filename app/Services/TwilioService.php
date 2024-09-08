<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->client = new Client($sid, $token);
    }

    public function sendWhatsAppMessage($to, $message)
    {
        $from = env('TWILIO_WHATSAPP_NUMBER'); // Your Twilio WhatsApp number

        $response = $this->client->messages
        ->create("whatsapp:+201068402235", // to
          array(
            "from" => "whatsapp:+14155238886",
            "body" => $message
          )
        );

        return $response;
    }
}
