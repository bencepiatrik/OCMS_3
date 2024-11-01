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
        return [
            'ben.slack.access_emojis' => [
                'tab' => 'Slack',
                'label' => 'Manage allowed emojis'
            ],
            'ben.slack.chat' => [
                'tab' => 'Slack',
                'label' => 'Manage chats'
            ],
            'ben.slack.user' => [
                'tab' => 'Slack',
                'label' => 'Manage users'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        /* REVIEW - neregistruješ žiadny admin area navigation, ale pre každý model máš urobený controller a fields.yaml / columns.yaml
        používaš niekde tieto controlleri a fields.yaml / columns.yaml? A taktiež celkovo prečo neregistruješ navigation? V leveli 2 si to implementoval myslím */
        return [
            'slack' => [
                'label'       => 'Ben Slack',
                'icon'        => 'icon-cogs',
                'permissions' => ['ben.slack.*'],
                'order'       => 500,
                'sideMenu'    => [
                    'emojisettings' => [
                        'label'       => 'Emoji Settings',
                        'url'         => Backend::url('ben/slack/emojisettings'),
                        'icon'        => 'icon-smile',
                        'permissions' => ['ben.slack.access_emojis'],
                    ],
                    'chats' => [
                        'category'    => 'Ben Slack',
                        'label'       => 'Chats',
                        'url'         => Backend::url('ben/slack/chat'),
                        'icon'        => 'icon-comments',
                        'permissions' => ['ben.slack.chat'],
                    ],
                    'users' => [
                        'category'    => 'Ben Slack',
                        'label'       => 'Users',
                        'url'         => Backend::url('ben/slack/user'),
                        'icon'        => 'icon-user',
                        'permissions' => ['ben.slack.chat'],
                    ],
                ],
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'emojis' => [
                'label'       => 'Emoji Settings',
                'description' => 'Manage allowed emojis.',
                'category'    => 'Ben Slack',
                'icon'        => 'icon-smile',
                'url'         => Backend::url('ben/slack/emojisettings'),
                'permissions' => ['ben.slack.access_emojis'],
                'order'       => 500,
                'keywords'    => 'emoji reaction',
            ],
            'chats' => [
                'category'    => 'Ben Slack',
                'label'       => 'Chats',
                'url'         => Backend::url('ben/slack/chat'),
                'icon'        => 'icon-comments',
                'permissions' => ['ben.slack.chat'],
            ],
            'users' => [
                'category'    => 'Ben Slack',
                'label'       => 'Users',
                'url'         => Backend::url('ben/slack/user'),
                'icon'        => 'icon-user',
                'permissions' => ['ben.slack.chat'],
            ],
        ];
    }

}
