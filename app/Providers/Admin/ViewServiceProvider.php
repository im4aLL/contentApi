<?php

namespace App\Providers\Admin;

use App\Models\Admin\Cat;
use App\Models\Admin\Content;
use App\Models\Admin\Menu;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLeftNavigation();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Compose left navigation for admin left menu
     */
    private function composeLeftNavigation()
    {
        view()->composer('admin.shared.left', function($view){
            $total = new \stdClass();
            $total->menu = Menu::count();
            $total->category = Cat::count();
            $total->content = Content::count();

            $view->with('total', $total);
        });
    }
}
