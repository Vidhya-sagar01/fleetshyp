<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add all missing fields as per Fship API v1.2.3.2 CreateReverseOrder
     */
    public function up(): void
    {
        Schema::table('fship_reverse_orders', function (Blueprint $table) {
            
            // 🔗 1. SELLER ID (Required - as per your request)
            if (!Schema::hasColumn('fship_reverse_orders', 'seller_id')) {
                $table->foreignId('seller_id')
                    ->after('id')
                    ->constrained('users')
                    ->onDelete('cascade');
                $table->index(['seller_id', 'status']);
            }
            
            // 🔗 2. WAREHOUSE/PICKUP ADDRESS ID
            if (!Schema::hasColumn('fship_reverse_orders', 'warehouse_id')) {
                $table->foreignId('warehouse_id')
                    ->after('forward_order_id')
                    ->nullable()
                    ->constrained('pickup_addresses')
                    ->onDelete('set null');
            }
            
            // 📍 3. CONSIGNEE/CUSTOMER DETAILS (Required by Fship API)
            $customerFields = [
                'consignee_name' => ['type' => 'string', 'after' => 'warehouse_id'],
                'consignee_phone' => ['type' => 'string'],
                'consignee_email' => ['type' => 'string', 'nullable' => true],
                'pickup_address' => ['type' => 'text'],
                'pickup_landmark' => ['type' => 'string', 'nullable' => true],
                'pickup_address_type' => ['type' => 'string', 'default' => 'Home'],
                'pickup_pincode' => ['type' => 'string', 'length' => 10],
                'pickup_city' => ['type' => 'string'],
                'pickup_state' => ['type' => 'string', 'nullable' => true],
            ];
            
            foreach ($customerFields as $field => $config) {
                if (!Schema::hasColumn('fship_reverse_orders', $field)) {
                    $method = $config['type'] === 'text' ? 'text' : 'string';
                    $column = $table->{$method}($field);
                    
                    if ($config['nullable'] ?? false) $column->nullable();
                    if (isset($config['default'])) $column->default($config['default']);
                    if (isset($config['length'])) $column->length($config['length']);
                    if (isset($config['after'])) $column->after($config['after']);
                }
            }
            
            // 💰 4. FINANCIAL DETAILS (Required by Fship API)
            $financialFields = [
                'invoice_number' => ['type' => 'string', 'nullable' => true],
                'order_amount' => ['type' => 'decimal', 'precision' => 15, 'scale' => 2, 'default' => 0],
                'tax_amount' => ['type' => 'decimal', 'precision' => 15, 'scale' => 2, 'default' => 0],
                'extra_charges' => ['type' => 'decimal', 'precision' => 15, 'scale' => 2, 'default' => 0],
                'total_amount' => ['type' => 'decimal', 'precision' => 15, 'scale' => 2],
                'cod_amount' => ['type' => 'decimal', 'precision' => 15, 'scale' => 2, 'default' => 0],
                'payment_mode' => ['type' => 'string', 'default' => 'COD'], // COD/Prepaid
            ];
            
            foreach ($financialFields as $field => $config) {
                if (!Schema::hasColumn('fship_reverse_orders', $field)) {
                    if ($config['type'] === 'decimal') {
                        $column = $table->decimal($field, $config['precision'], $config['scale']);
                    } else {
                        $column = $table->string($field);
                    }
                    if ($config['nullable'] ?? false) $column->nullable();
                    if (isset($config['default'])) $column->default($config['default']);
                }
            }
            
            // 📏 5. SHIPMENT DIMENSIONS (Required by Fship API)
            $dimensionFields = [
                'shipment_weight' => ['nullable' => false, 'default' => null],
                'shipment_length' => ['nullable' => false, 'default' => 0],
                'shipment_width' => ['nullable' => false, 'default' => 0],
                'shipment_height' => ['nullable' => false, 'default' => 0],
                'volumetric_weight' => ['nullable' => true, 'default' => null],
            ];
            
            foreach ($dimensionFields as $field => $config) {
                if (!Schema::hasColumn('fship_reverse_orders', $field)) {
                    $column = $table->decimal($field, 10, 2);
                    if ($config['nullable']) $column->nullable();
                    if (isset($config['default'])) $column->default($config['default']);
                }
            }
            
            // 🚚 6. COURIER & TRACKING
            if (!Schema::hasColumn('fship_reverse_orders', 'courier_id')) {
                $table->integer('courier_id')->nullable()->after('courier_name');
            }
            if (!Schema::hasColumn('fship_reverse_orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->unique()->after('status');
            }
            
            // 📊 7. STATUS TIMESTAMPS
            $statusTimestamps = ['picked_at', 'delivered_at', 'cancelled_at'];
            foreach ($statusTimestamps as $ts) {
                if (!Schema::hasColumn('fship_reverse_orders', $ts)) {
                    $table->timestamp($ts)->nullable();
                }
            }
            if (!Schema::hasColumn('fship_reverse_orders', 'cancellation_reason')) {
                $table->string('cancellation_reason')->nullable();
            }
            
            // 🗄️ 8. API REQUEST/RESPONSE STORAGE
            $apiFields = ['api_request', 'api_response'];
            foreach ($apiFields as $field) {
                if (!Schema::hasColumn('fship_reverse_orders', $field)) {
                    $table->json($field)->nullable();
                }
            }
            if (!Schema::hasColumn('fship_reverse_orders', 'is_valid')) {
                $table->boolean('is_valid')->default(true);
            }
            
            // 📝 9. ADDITIONAL FIELDS
            if (!Schema::hasColumn('fship_reverse_orders', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (!Schema::hasColumn('fship_reverse_orders', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('fship_reverse_orders', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
            
            // 📈 10. INDEXES FOR PERFORMANCE
            $table->index(['reverse_waybill', 'seller_id']);
            $table->index(['pickup_pincode']);
            $table->index(['forward_order_id', 'seller_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fship_reverse_orders', function (Blueprint $table) {
            // Remove only the columns we added (safe rollback)
            $columnsToRemove = [
                'seller_id', 'warehouse_id',
                'consignee_name', 'consignee_phone', 'consignee_email',
                'pickup_address', 'pickup_landmark', 'pickup_address_type',
                'pickup_pincode', 'pickup_city', 'pickup_state',
                'invoice_number', 'order_amount', 'tax_amount',
                'extra_charges', 'total_amount', 'cod_amount', 'payment_mode',
                'shipment_weight', 'shipment_length', 'shipment_width',
                'shipment_height', 'volumetric_weight',
                'courier_id', 'tracking_number',
                'picked_at', 'delivered_at', 'cancelled_at', 'cancellation_reason',
                'api_request', 'api_response', 'is_valid',
                'notes', 'latitude', 'longitude',
            ];
            
            $existingColumns = array_filter($columnsToRemove, fn($col) => 
                Schema::hasColumn('fship_reverse_orders', $col)
            );
            
            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
            
            // Drop indexes if they exist
            $indexes = [
                'fship_reverse_orders_seller_id_status_index',
                'fship_reverse_orders_reverse_waybill_seller_id_index',
                'fship_reverse_orders_pickup_pincode_index',
                'fship_reverse_orders_forward_order_id_seller_id_index',
            ];
            
            foreach ($indexes as $index) {
                try {
                    $table->dropIndex($index);
                } catch (\Exception $e) {
                    // Index may not exist, ignore
                }
            }
        });
    }
};