<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deal;
use App\Services\TwilioService;
use App\Events\DealClosed;

class NotifyClosedDeals extends Command
{
    protected $signature = 'deals:notify-closed';
    protected $description = 'Send notifications for closed deals';
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
    }

    public function handle()
    {
        $closedDeals = Deal::where('status', 'Closed')->where('notified', false)->get();

        foreach ($closedDeals as $deal) {
            // Fire the DealClosed event
            event(new DealClosed($deal));

            $message = "Deal Name '{$deal->name}' With Amount '{$deal->amount}' has been closed.";
            $this->twilioService->sendWhatsAppMessage("+201068402235", $message);
            $deal->notified = true;
            $deal->save();
        }

        $this->info('Notifications sent for closed deals.');
    }
}