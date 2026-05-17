<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FshipOrder;
use App\Services\FshipService;
use Illuminate\Support\Facades\Log;

class SyncOrderStatus extends Command
{
    protected $signature = 'sync:orders';
    protected $description = 'Sync order status from Fship API';

    protected $fshipService;

    public function handle()
    {
        $this->fshipService = app(FshipService::class);

        $this->info('🔄 Order status sync started...');
        Log::info('SyncOrderStatus: Job started');

        FshipOrder::whereNotNull('waybill')
            ->whereNotIn('status', ['booked', 'delivered', 'cancelled'])  // ✅ 'rto' ab include hoga
            ->chunkById(50, function ($orders) {

                foreach ($orders as $order) {
                    try {
                        Log::debug('SyncOrderStatus: Processing order', [
                            'order_id' => $order->id,
                            'waybill' => $order->waybill,
                            'current_status' => $order->status
                        ]);

                        $res = $this->fshipService->getTrackingHistory($order->waybill);

                        if (
                            isset($res['status']) &&
                            $res['status'] === true &&
                            !empty($res['summary']['status'])
                        ) {
                            $apiStatus = $res['summary']['status'];
                            $normalizedStatus = $this->normalizeStatus($apiStatus);

                            // ✅ Status update karein agar change hua ho
                            if ($order->status !== $normalizedStatus) {
                                $oldStatus = $order->status;
                                $order->status = $normalizedStatus;
                                $order->save();

                                $this->info("Order #{$order->id}: {$oldStatus} → {$normalizedStatus}");

                                Log::info('Order status updated', [
                                    'order_id' => $order->id,
                                    'waybill' => $order->waybill,
                                    'old_status' => $oldStatus,
                                    'new_status' => $normalizedStatus
                                ]);
                            }

                            // 🔥 RTO CHECK - AB STATUS CHANGE KE BAHAR (Key Change!)
                            // Chahe status pehle se 'rto' ho ya abhi change hua ho,
                            // agar rto_processed === 0 hai to process karega
                            if ($normalizedStatus === 'rto' && (int)$order->rto_processed === 0) {
                                
                                Log::info('RTO: Processing pending RTO order', [
                                    'order_id' => $order->id,
                                    'waybill' => $order->waybill,
                                    'rto_processed' => $order->rto_processed,
                                    'status' => $order->status
                                ]);

                                try {
                                    app(\App\Services\RtoService::class)->process($order->id);
                                    
                                    Log::info('RTO: Service call completed successfully', [
                                        'order_id' => $order->id
                                    ]);
                                    $this->info("✅ RTO processed for Order #{$order->id}");
                                    
                                } catch (\Throwable $e) {
                                    Log::error('RTO: Service call failed', [
                                        'order_id' => $order->id,
                                        'error' => $e->getMessage(),
                                        'file' => $e->getFile(),
                                        'line' => $e->getLine(),
                                        'trace' => $e->getTraceAsString()
                                    ]);
                                    $this->error("❌ RTO Service failed for Order #{$order->id}: {$e->getMessage()}");
                                }
                            }

                        } else {
                            Log::warning('Invalid API response', [
                                'order_id' => $order->id,
                                'waybill' => $order->waybill,
                                'response' => $res
                            ]);
                        }

                    } catch (\Throwable $e) {
                        Log::error('Sync failed', [
                            'order_id' => $order->id,
                            'waybill' => $order->waybill,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);

                        $this->error("❌ Order #{$order->id} failed: {$e->getMessage()}");
                    }
                }
            });

        Log::info('SyncOrderStatus: Job completed');
        $this->info('✅ Order status sync completed.');
    }

    private function normalizeStatus($status)
    {
        $status = strtolower(trim($status));

        return match (true) {
            // 📦 Booked / Manifested
            in_array($status, [
                'booked',
                'order booked',
                'shipment booked'
            ]) => 'booked',

            in_array($status, [
                'manifested',
                'pickup initiated',
                'pickup scheduled'
            ]) => 'manifested',

            // 🚚 Picked up
            in_array($status, [
                'out for pickup',
                'Pickup Pending',
                'pickup has been registered',
                'pickup pending',
                'pickup_pending',
                'pick up scan on field'
            ]) => 'picked_up',

            // 🚛 Transit
            in_array($status, [
                'in transit',
                'dispatched',
                'on route',
                'pickup completed'
            ]) => 'in_transit',

            // ✅ Delivered
            $status === 'delivered' => 'delivered',

            // ❌ Cancelled
            in_array($status, ['cancelled', 'canceled']) => 'cancelled',

            // 🔄 RTO
            $status === 'rto' => 'rto',

            $status === 'rto in transit' => 'rto_in_transit',

            $status === 'rto delivered' => 'rto_delivered',

            default => str_replace([' ', '-'], '_', $status),
        };
    }
}