<?php

namespace App\Helpers;

class WalletHelper
{
    public static function getSourceIcon(?string $source): string
    {
        return match ($source) {
            'admin_manual' => '<i class="fa fa-user-tie text-blue-500"></i>',
            'razorpay' => '<i class="fa fa-credit-card text-indigo-500"></i>',
            'stripe' => '<i class="fa fa-credit-card text-purple-500"></i>',
            'paytm' => '<i class="fa fa-mobile-alt text-blue-400"></i>',
            'phonepe' => '<i class="fa fa-mobile-alt text-purple-400"></i>',
            'gpay' => '<i class="fa fa-google text-green-500"></i>',
            'fship_refund' => '<i class="fa fa-undo text-amber-500"></i>',
            'forward' => '<i class="fa fa-truck text-gray-500"></i>',
            'cod' => '<i class="fa fa-money-bill-wave text-orange-500"></i>',
            'rto' => '<i class="fa fa-undo text-red-400"></i>',
            'recharge' => '<i class="fa fa-battery-full text-green-500"></i>',
            'adjustment' => '<i class="fa fa-cog text-gray-400"></i>',
            'penalty' => '<i class="fa fa-exclamation-triangle text-red-500"></i>',
            default => '<i class="fa fa-circle text-gray-300"></i>',
        };
    }

    public static function getSourceLabel(?string $source): string
    {
        return match ($source) {
            'admin_manual' => 'Admin',
            'razorpay' => 'Razorpay',
            'stripe' => 'Stripe',
            'paytm' => 'Paytm',
            'phonepe' => 'PhonePe',
            'gpay' => 'GPay',
            'fship_refund' => 'FShip Refund',
            'forward' => 'Forward',
            'cod' => 'COD',
            'rto' => 'RTO',
            'recharge' => 'Recharge',
            'adjustment' => 'Adjustment',
            'penalty' => 'Penalty',
            default => ucfirst(str_replace('_', ' ', $source ?? 'unknown')),
        };
    }

    public static function getSourceBadgeClass(?string $source): string
    {
        return match ($source) {
            'admin_manual' => 'bg-blue-100 text-blue-700',
            'razorpay', 'stripe' => 'bg-indigo-100 text-indigo-700',
            'paytm', 'phonepe', 'gpay' => 'bg-purple-100 text-purple-700',
            'fship_refund' => 'bg-amber-100 text-amber-700',
            'forward', 'cod', 'rto' => 'bg-gray-100 text-gray-700',
            'recharge' => 'bg-green-100 text-green-700',
            'adjustment' => 'bg-gray-100 text-gray-600',
            'penalty' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}