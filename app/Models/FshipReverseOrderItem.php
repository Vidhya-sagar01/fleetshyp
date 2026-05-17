<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FshipReverseOrderItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fship_reverse_order_items';

    /**
     * The attributes that are mass assignable.
     * Mapped from Fship API CreateReverseOrder payload (products array).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reverse_order_id',
        
        // Product Details (Required by Fship API)
        'product_name',      // productName *required
        'sku',               // sku
        'quantity',          // quantity *required
        'unit_price',        // unitPrice *required
        'total_price',       // calculated: quantity * unit_price
        
        // Product Metadata (Required if QC is enabled)
        'product_category',  // productCategory
        'hsn_code',          // hsnCode
        'brand_name',        // brandName *required if isQcRequired=true
        'color',             // color *required if isQcRequired=true
        'size',              // size *required if isQcRequired=true
        'ean_no',            // eanNo
        'serial_no',         // serialNo
        'imei',              // imei
        'is_fragile',        // isFragileProduct
        'image_url',         // productImageUrl
        
        // Return Specific
        'return_reason',     // returnReason
        'return_type',       // returnType: 0=Return, 1=Exchange
        
        // QC Parameters (JSON array as per Fship API spec)
        // Format: [{"questionId":"Take_Picture","question":"...","value":"Yes"}]
        'qc_parameters',
        
        'sort_order',        // For ordering products in UI/API
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'return_type' => 'integer',
        'sort_order' => 'integer',
        'is_fragile' => 'boolean',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'qc_parameters' => 'array',  // Auto-encode/decode JSON
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add fields to hide in API responses if needed
        // 'qc_parameters', // Uncomment if QC params are internal only
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'formatted_price',
        'formatted_total',
    ];

    // ===== Relationships =====

    /**
     * Get the reverse order that owns this item.
     */
    public function reverseOrder(): BelongsTo
    {
        return $this->belongsTo(FshipReverseOrder::class, 'reverse_order_id');
    }

    // ===== Accessors & Mutators =====

    /**
     * Calculate total_price if not set (quantity * unit_price).
     */
    public function setQuantityAttribute($value): void
    {
        $this->attributes['quantity'] = (int) $value;
        
        // Auto-calculate total_price if unit_price exists
        if (isset($this->attributes['unit_price']) && !isset($this->attributes['total_price'])) {
            $this->attributes['total_price'] = (float) $value * (float) $this->attributes['unit_price'];
        }
    }

    /**
     * Set unit_price and auto-calculate total_price.
     */
    public function setUnitPriceAttribute($value): void
    {
        $this->attributes['unit_price'] = (float) $value;
        
        // Auto-calculate total_price if quantity exists
        if (isset($this->attributes['quantity'])) {
            $this->attributes['total_price'] = (float) $this->attributes['quantity'] * (float) $value;
        }
    }

    /**
     * Format QC parameters for Fship API payload.
     * Ensures value is strictly "Yes" or "No" as per API spec.
     */
    public function setQcParametersAttribute($value): void
    {
        if (is_array($value)) {
            $normalized = array_map(function($qc) {
                return [
                    'questionId' => $qc['questionId'] ?? $qc['question_id'] ?? '',
                    'question' => $qc['question'] ?? '',
                    'value' => in_array(strtolower($qc['value'] ?? ''), ['yes', 'no']) 
                        ? ucfirst(strtolower($qc['value'])) 
                        : 'No', // Default to "No" if invalid
                ];
            }, $value);
            $this->attributes['qc_parameters'] = json_encode($normalized);
        } else {
            $this->attributes['qc_parameters'] = $value;
        }
    }

    // ===== Accessors (Getters) =====

    /**
     * Get formatted unit price with currency symbol.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->unit_price, 2);
    }

    /**
     * Get formatted total price with currency symbol.
     */
    public function getFormattedTotalAttribute(): string
    {
        return '₹' . number_format($this->total_price, 2);
    }

    /**
     * Get return type as human-readable string.
     */
    public function getReturnTypeLabelAttribute(): string
    {
        return $this->return_type === 1 ? 'Exchange' : 'Return';
    }

    /**
     * Check if QC parameters are present and valid.
     */
    public function getHasQcParametersAttribute(): bool
    {
        return !empty($this->qc_parameters) && is_array($this->qc_parameters);
    }

    // ===== Scopes =====

    /**
     * Scope a query to only include fragile products.
     */
    public function scopeFragile($query)
    {
        return $query->where('is_fragile', true);
    }

    /**
     * Scope a query to only include items with QC parameters.
     */
    public function scopeWithQc($query)
    {
        return $query->whereNotNull('qc_parameters')
                    ->where('qc_parameters', '!=', '[]');
    }

    /**
     * Scope a query to filter by return type.
     */
    public function scopeByReturnType($query, $type)
    {
        return $query->where('return_type', $type);
    }

    /**
     * Scope a query to search products by name or SKU.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('product_name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('brand_name', 'like', "%{$search}%");
        });
    }

    // ===== Helpers =====

    /**
     * Calculate total price dynamically (if not stored).
     */
    public function calculateTotal(): float
    {
        return (float) $this->quantity * (float) $this->unit_price;
    }

    /**
     * Check if this item requires QC based on parent order.
     */
    public function requiresQc(): bool
    {
        return $this->reverseOrder?->is_qc_required ?? false;
    }

    /**
     * Get QC parameters formatted for Fship API payload.
     * Returns array ready for API submission.
     */
    public function getQcPayload(): array
    {
        if (empty($this->qc_parameters) || !is_array($this->qc_parameters)) {
            return [];
        }

        return array_map(function($qc) {
            return [
                'questionId' => $qc['questionId'] ?? '',
                'question' => $qc['question'] ?? '',
                'value' => $qc['value'] ?? 'No', // Must be "Yes" or "No"
            ];
        }, $this->qc_parameters);
    }

    /**
     * Get product details formatted for Fship API CreateReverseOrder.
     */
    public function toFshipApiPayload(): array
    {
        $payload = [
            'productId' => $this->sku ?? uniqid('prod_'),
            'productName' => $this->product_name,
            'quantity' => (int) $this->quantity,
            'unitPrice' => (float) $this->unit_price,
            'productCategory' => $this->product_category ?? '',
            'sku' => $this->sku ?? '',
            'hsnCode' => $this->hsn_code ?? '',
            'taxRate' => 0, // Default, can be calculated if GST info available
            'productDiscount' => 0, // Default
            'brandName' => $this->brand_name ?? '',
            'color' => $this->color ?? '',
            'size' => $this->size ?? '',
            'eanNo' => $this->ean_no ?? '',
            'serialNo' => $this->serial_no ?? '',
            'imei' => $this->imei ?? '',
            'isFragileProduct' => (bool) $this->is_fragile,
            'productImageUrl' => $this->image_url ?? '',
            'returnType' => (int) $this->return_type,
            'returnReason' => $this->return_reason ?? '',
        ];

        // Add QC parameters only if present and valid
        if ($this->has_qc_parameters) {
            $payload['qcParameters'] = $this->getQcPayload();
        }

        return $payload;
    }

    /**
     * Get status badge class for UI display.
     */
    public function getReturnTypeBadgeClass(): string
    {
        return $this->return_type === 1 
            ? 'bg-purple-100 text-purple-800'  // Exchange
            : 'bg-blue-100 text-blue-800';     // Return
    }
}