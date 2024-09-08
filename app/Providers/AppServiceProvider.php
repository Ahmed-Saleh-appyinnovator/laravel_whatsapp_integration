<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\DealClosed;
use App\Listeners\SendDealClosedNotification;
use Illuminate\Support\Facades\Artisan;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DealClosed::class => [
            SendDealClosedNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
        // Run the command immediately

        Artisan::call('deals:notify-closed');
    }
}
