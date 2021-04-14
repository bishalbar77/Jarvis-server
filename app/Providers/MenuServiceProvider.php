<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if(Auth::id() == '6'):
            $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenuOPS.json'));
            $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenuOPS.json'));
        else:
            $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
            $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenu.json'));
        endif;

        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuData = json_decode($horizontalMenuJson);

        // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData, $horizontalMenuData]);
    }
}
