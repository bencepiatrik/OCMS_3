<?php namespace Ben\Slack;

use Backend;
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
            'name' => 'Slack',
            'description' => 'No description provided yet...',
            'author' => 'Ben',
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
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Ben\Slack\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'ben.slack.some_permission' => [
                'tab' => 'Slack',
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
            'slack' => [
                'label' => 'Slack',
                'url' => Backend::url('ben/slack/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['ben.slack.*'],
                'order' => 500,
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'Emoji Settings',
                'description' => 'Manage allowed emojis.',
                'category'    => 'Ben Slack',
                'icon'        => 'icon-smile',
                'url'         => Backend::url('ben/slack/emojisettings'),
                'permissions' => ['ben.slack.access_emojis'],
                'order'       => 500,
                'keywords'    => 'emoji reaction',
            ]
        ];
    }

}
