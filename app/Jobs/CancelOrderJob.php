<?php

namespace App\Jobs;

use App\Enums\UserEnum;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class CancelOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        $payment = Payment::where('order_id', $order->order_id)->first();
        if($payment && $payment->payment_status=='pending'){
            $orderCode=$order->order_id;
            $apiUrl =  UserEnum::URL_SERVER."/orders/payos/$orderCode/cancel";
            try{
                $response=Http::post($apiUrl);
                if ($response->successful()) {
                    Log::info("Hủy thanh toán thành công cho OrderCode: {$orderCode}");
                } else {
                    Log::error("Lỗi khi hủy thanh toán", [
                        'orderCode' => $orderCode,
                        'response' => $response->json(),
                    ]);
                }
            }
            catch(\Exception $e){
                Log::error("Lỗi khi hủy thanh toán", [
                    'orderCode' => $orderCode,
                    'error' => $e->getMessage(),
                ]);
            }
           
        }
    }
}
