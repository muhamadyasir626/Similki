<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\LembagaKonservasi' => 'App\Policies\LembagaKonservasiPolicy',
        'App\Models\verifikasi' => 'App\Policies\verifikasiPolicy',
        'App\Models\BarangKonservasi' => 'App\Policies\BarangKonservasiPolicy',
        'App\Models\SatwaTitipan' => 'App\Policies\SatwaTitipanPolicy',
        'App\Models\SatwaPerolehan' => 'App\Policies\SatwaPerolehanPolicy',
        'App\Models\SatwaKoleksiIndividu' => 'App\Policies\SatwaKoleksiIndividuPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
