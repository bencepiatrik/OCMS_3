<?php namespace CustomSlack\Chat;

use Backend;
use Illuminate\Support\Facades\App;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Chat',
            'description' => 'No description provided yet...',
            'author' => 'CustomSlack',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        include __DIR__ . '/routes.php';

    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'CustomSlack\Chat\Components\Profile' => 'profile'
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'customslack.chat.some_permission' => [
                'tab' => 'Chat',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'chat' => [
                'label' => 'Chat',
                'url' => Backend::url('customslack/chat/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['customslack.chat.*'],
                'order' => 500,
            ],
        ];
    }
}
