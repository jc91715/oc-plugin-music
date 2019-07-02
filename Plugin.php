<?php namespace Jc91715\Music;

use Backend;
use System\Classes\PluginBase;
use Jc91715\Music\Classes\MusicAdapterInterface;
use Jc91715\Music\Classes\MetAdapter;
use Jc91715\Music\Classes\MusicInterface;
use Jc91715\Music\Classes\Music;
/**
 * music Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'music',
            'description' => 'No description provided yet...',
            'author'      => 'jc91715',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(MusicAdapterInterface::class,function (){
            return new MetAdapter();
        });
        app()->bind(MusicInterface::class,function (){
            return new Music();
        });

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Jc91715\Music\Components\Meting' => 'Meting',
            'Jc91715\Music\Components\Download' => 'Download',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'jc91715.music.some_permission' => [
                'tab' => 'music',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'music' => [
                'label'       => 'music',
                'url'         => Backend::url('jc91715/music/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['jc91715.music.*'],
                'order'       => 500,
            ],
        ];
    }
}
