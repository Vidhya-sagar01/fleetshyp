<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind(); 

        // ✅ Ab ye directives kaam karenge
        Blade::directive('getSourceIcon', function($source) {
            return "<?php echo \App\Helpers\WalletHelper::getSourceIcon($source); ?>";
        });

        Blade::directive('getSourceLabel', function($source) {
            return "<?php echo \App\Helpers\WalletHelper::getSourceLabel($source); ?>";
        });

        Blade::directive('getSourceBadgeClass', function($source) {
            return "<?php echo \App\Helpers\WalletHelper::getSourceBadgeClass($source); ?>";
        });
    }
}