<?php

namespace App\Jobs;

use App\Jobs\Mail\OrderCompletedMail;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class OrderCompletedJob
 * @package App\Jobs
 */
class OrderCompletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $orderId;

    /**
     * PayInvoiceJob constructor.
     * @param int $orderId
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);
        $partnerEmail = $order->partner ? $order->partner->email : null;

        $vendorsEmails = Vendor::whereIn(
            'id',
            $order->originalProducts()->select('vendor_id')->distinct()->pluck('vendor_id')
        )->pluck('email');

        $vendorsEmails->merge([$partnerEmail])
            ->each(static function (string $email) use ($order) {
                app('mailer')->queue(
                    new OrderCompletedMail($order, $email)
                );
            });
    }
}
