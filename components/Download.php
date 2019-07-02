<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;


use Jc91715\Music\Classes\MusicInterface;

class Download extends ComponentBase
{

    protected $music;
    public function componentDetails()
    {
        return [
            'name'        => 'download Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init()
    {

    }

    public function onRun()
    {
        $type=$this->param('type');
        $id=$this->param('id');
        header('Cache-Control: max-age=3600*24');
        switch ($type){
            case 'mp3':
                app(MusicInterface::class)->downloadMp3($id);
                break;
            case 'img':
                app(MusicInterface::class)->downloadImg($id);
                break;
            case 'lrc':
                app(MusicInterface::class)->downloadLrc($id);
                break;
            default:
                abort(404);
                break;
        }
    }

}
