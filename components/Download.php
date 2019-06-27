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
        $this->api = new Met('netease');
    }

    public function onRun()
    {
        $id=$this->param('id');
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
}
