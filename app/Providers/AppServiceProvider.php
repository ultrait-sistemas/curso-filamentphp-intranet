<?php

namespace App\Providers;

use App\Models\User;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            if(Auth::user()) {
                $user = User::find(Auth::user()->id);
                $panelSwitch
                    ->visible(fn (): bool => $user?->hasAnyRole([
                        'super_admin',
                    ]));        
            }
        });
    }
}
