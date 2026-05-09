<?php

namespace App\Jobs;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessDailySalesJob implements ShouldQueue
{
    use Queueable,Dispatchable,InteractsWithQueue,SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
{
    $dailyTotal = 0;
    $orderCount = 0;
    $productsCount = 0;

    Order::whereDate('created_at', Carbon::today())
        ->chunk(500, function($orders) use (&$dailyTotal, &$orderCount, &$productsCount) {

            foreach ($orders as $order) {

                if (isset($order->total)) {
                    $dailyTotal += $order->total;
                }

                $orderCount++;

                if (method_exists($order, 'products')) {
                    $productsCount += $order->products()->sum('quantity');
                }
            }

        });

    DB::table('daily_reports')->insert([
        'date' => Carbon::today(),
        'total_sales' => $dailyTotal,
        'orders_count' => $orderCount,
        'products_count' => $productsCount,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
}
