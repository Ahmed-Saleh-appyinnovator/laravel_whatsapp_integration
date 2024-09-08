<?php
namespace App\Listeners;

use App\Events\DealClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\TwilioService;

class SendDealClosedNotification implements ShouldQueue
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function handle(DealClosed $event)
    {
        $deal = $event->deal;
        $message = "Deal Name '{$deal->name}' With Amount '{$deal->amount}' has been closed.";
        
        // Send the notification
        $this->twilioService->sendWhatsAppMessage("+201068402235", $message);
    }
}

