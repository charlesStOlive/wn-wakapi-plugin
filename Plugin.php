<?php namespace Waka\Wakapi;

use Waka\Wakapi\Classes\HandleCors;
use Waka\Wakapi\Classes\HandlePreflight;
use Waka\Wakapi\Classes\ServiceProvider;
use Waka\Wakapi\Models\Settings;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        \App::register(ServiceProvider::class);

        $this->app['Illuminate\Contracts\Http\Kernel']
            ->prependMiddleware(HandleCors::class);

        if (request()->isMethod('OPTIONS')) {
            $this->app['Illuminate\Contracts\Http\Kernel']
                ->prependMiddleware(HandlePreflight::class);
        }
        $this->app['router']->aliasMiddleware('csrf', '\Waka\Wakapi\Classes\Middleware\AddCsrfToken');
    }

    public function registerPermissions()
    {
        return [
            'waka.wakapi.manage' => [
                'label' => 'Can manage cors settings',
                'tab'   => 'CORS',
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'cors' => [
                'label'       => 'CORS-Settings',
                'description' => 'Manage CORS headers',
                'category'    => 'system::lang.system.categories.cms',
                'icon'        => 'icon-code',
                'class'       => Settings::class,
                'order'       => 500,
                'keywords'    => 'cors',
                'permissions' => ['waka.wakapi.manage'],
            ],
        ];
    }
}
