<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;
use Metowolf\Meting as Met;

class Download extends ComponentBase
{
    protected $api;
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

        $suppose = array('netease', 'tencent', 'xiami', 'kugou', 'baidu');
        $pingtai = request()->get('pingtai','netease');
        if(!in_array($pingtai,$suppose)){
            $pingtai='netease';
        }


        $this->api = new Met($pingtai);
    }

    public function onRun()
    {
        $type=$this->param('type');
        $id=$this->param('id');
        header('Cache-Control: max-age=3600*24');
        switch ($type){
            case 'mp3':
                $this->downMusic($id);
                break;
            case 'img':
                $this->downImg($id);
                break;
            case 'lrc':
                $this->downLrc($id);
                break;
            default:
                abort(404);
                break;
        }

    }

    protected function downMusic($id)
    {
        $data= $this->api->format(true)->url($id);
        $data=json_decode($data,true);
        $url = $data['url'];

        $file = file_get_contents($url);

        $path_parts  = pathinfo($url);
        $fileName= $path_parts['basename'];
        if(request()->get('file_name')){
            $fileName= request()->get('file_name').'.'.$path_parts['extension'];
        }

        header("Content-type:audio/mpeg");
        header("Accept-Ranges:bytes");
        header("Accept-Length:".strlen($file));
        header("Content-Disposition:attachment;filename=".$fileName);
        echo $file;
        exit();
    }
    public function downImg($id)
    {
        $data= $this->api->format(true)->pic($id);
        $data=json_decode($data,true);
        $url = $data['url'];
        $file = file_get_contents($url);
        $path_parts  = pathinfo($url);
        $fileName= $path_parts['basename'];

        header("Accept-Ranges:bytes");
        header("Accept-Length:".strlen($file));
        header("Content-Disposition:attachment;filename=".$fileName);
        echo $file;
        exit();
    }
    public function downLrc($id)
    {
        $data= $this->api->format(true)->lyric($id);
        $data=json_decode($data,true);
        $lyric = $data['lyric'];
        header("Content-type:text/html; charset=UTF-8");
        header("Accept-Length:".strlen($lyric));
        echo $lyric;
        exit();
    }
}
