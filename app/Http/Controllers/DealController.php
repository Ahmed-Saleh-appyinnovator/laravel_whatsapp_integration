<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Events\DealClosed;
use App\Services\TwilioService;

class DealController extends Controller
{

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    // function to check if deal closed - send notification and change notified to avoid duplications of notification:
    // public function notifyClosedDeals()
    // {
    //     // Fetch deals that are closed and have not been notified yet
    //     $closedDeals = Deal::where('status', 'Closed')->where('notified', false)->get();

    //     foreach ($closedDeals as $deal) {

    //         $message = "Deal Name '{$deal->name}' With Amount' {{$deal->amount}} ' has been closed.";

    //         // Send WhatsApp message
    //         $this->twilioService->sendWhatsAppMessage("+201068402235", $message);

    //         // Mark deal as notified to avoid sending duplicate notifications
    //         $deal->notified = true;
    //         $deal->save();
    //     }
    // }
    public function notifyClosedDeals()
    {
        // Fetch deals that are closed and have not been notified yet
        $closedDeals = Deal::where('status', 'Closed')->where('notified', false)->get();

        foreach ($closedDeals as $deal) {
            // Fire the DealClosed event
            event(new DealClosed($deal));

            // Mark deal as notified to avoid sending duplicate notifications
            $deal->notified = true;
            $deal->save();
        }

        // Monthly total amount closed deal:
        $monthlyClosedDeals = Deal::where('status', 'Closed')

            ->where('notified', false)

            ->groupBy(Deal::raw('MONTH(created_at)'))

            ->groupBy(Deal::raw('YEAR(created_at)'))

            ->select(Deal::raw('SUM(amount) as total_amount'), Deal::raw('MONTH(created_at) as month'), Deal::raw('YEAR(created_at) as year'))

            ->get();

            foreach ($monthlyClosedDeals as $deal) {
                // Fire the DealClosed event
                event(new DealClosed($deal));
    
            }
    }

    public function index(){

        
        $this->notifyClosedDeals();
        // // Fetch all deals with status 'Closed'
        // $closedDeals = Deal::where('status', 'Closed')->where('notified', false)->get();

        // $message=[];

        // // Send WhatsApp notification for each closed deal
        // if($closedDeals->isNotEmpty()){

        //     foreach ($closedDeals as $deal) {
                
        //         $message[] = "Deal Name '{$deal->name}' With Amount' {{$deal->amount}} ' has been closed.";
                

        //         // Send the WhatsApp message using TwilioService
        //         $this->twilioService->sendWhatsAppMessage("+201068402235", $message);
                
        //         // Mark deal as notified to avoid sending duplicate notifications
        //         $deal->notified = true;
        //         $deal->save();
                
        //     }
        //     // dd($message);
        // }

        $dealsFromDB = Deal::all();
        return view('deals.index', ['deals'=>$dealsFromDB]);
    }

    public function create(){
        return view('deals.create');
    }

    public function show($dealId){
        $dealsFromDB = Deal::find($dealId);
        return view('deals.show', ['deals'=>$dealsFromDB]);
    }

    public function store(){

        $deal_name = request()->deal_name;
        $deal_amount = request()->deal_amount;
        $deal_status = request()->status;
        
        $deal = new Deal;
 
        $deal->name = $deal_name;
        $deal->amount = $deal_amount;
        $deal->status = $deal_status;
 
        $deal->save();

        // // Check if the status is 'Closed'
        // if ($deal->status === 'Closed') {
        //     $message = "A deal has been closed.\n"
        //                 . "Deal Name: {$deal->name}\n"
        //                 . "Amount: {$deal->amount}\n"
        //                 . "Status: Closed";

        //     // Send WhatsApp message
        //     $response = $this->twilioService->sendWhatsAppMessage('+201068402235', $message);

        // }
 
        return to_route('deals.index');
    }

    
}
