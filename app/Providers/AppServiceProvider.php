<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Schema::defaultStringLength(191);
        //date_default_timezone_set('Asia/Riyadh');
        // $inactive_users=DB::table('users')->where([['is_active','0'],['account_type','0'],['deleted_at',NULL]])->count();

        // $inactive_influncers=DB::table('users')->where([['is_active','0'],['account_type','1'],['deleted_at',NULL]])->count();

        // $inactive_campaigns=DB::table('campaigns')->where([['status','0'],['deleted_at',NULL]])->count();

        //  $inactive_transactions=DB::table('transactions')->where([['status','0'],['deleted_at',NULL]])->count();
        //  $userSocial = DB::table('user_socials')->count();
        
        // View::share('inactive_users', $inactive_users);

        // View::share('inactive_influncers', $inactive_influncers);

        // View::share('inactive_campaigns', $inactive_campaigns);

        // View::share('inactive_transactions', $inactive_transactions);

        // View::share('userSocial', $userSocial);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
