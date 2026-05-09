<?php

namespace App\Jobs;

use App\Mail\OrderCreatedMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    use Queueable,Dispatchable,InteractsWithQueue,SerializesModels;

    public $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // Mail::to($this->order->user->email)
        // ->send(new OrderCreatedMail($this->order));
        Mail::raw('Mailtrap test',function($m){
            $m->to('test@example.com')->subject('Mailtrap test');
        });
    }
}
