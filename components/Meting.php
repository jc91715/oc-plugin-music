<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;
use Metowolf\Meting as Met;
use Cms\Classes\Page;

class Meting extends ComponentBase
{
    protected $api;
    protected $downPage;

    public function componentDetails()
    {
        return [
            'name'        => 'meting Component',
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
       $this->downPage = 'download';
    }

    public function onRun()
    {
        $this->addCss('assets/css/APlayer.min.css');
        $this->addJs('assets/js/APlayer.min.js');



       $api = new Met('netease');
//// Use custom cookie (option)
//// $api->cookie('paste your cookie');
//
//// Get data
//        $data = $api->format(true)->search('朋友', [
//            'page' => 1,
//            'limit' => 10
//        ]);
//        $data= $api->format(true)->url(152428);
//        $data= $api->format(true)->pic(152428);
//        $data= $api->format(true)->lyric(152428);
//        echo $data;
    }

    public function onSearch()
    {
        $search=post('search');
        $page = request()->get('page',1);
        $data = $this->api->format(true)->search($search, [
            'page' => $page,
            'limit' => 10
        ]);
        $data=json_decode($data,true);
        $musics = [];

        foreach ($data as &$v){
            $v['artist'] = implode(',',$v['artist']);
            $music=[];
            $music['name']= $v['name'];
            $music['artist']= $v['artist'];
            $music['url']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'mp3']);
            $music['lrc']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'lrc']);
            $music['cover']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'img']);
            $musics[]=$music;
        }
        $count=count($data);
        $ifDisplayNextPage=true;
        if($count<10){
            $ifDisplayNextPage=false;
        }
        $this->page['search']= $search;
        $this->page['page']= $page-1;
        $this->page['nextPage']= $page+1;
        $this->page['ifDisplayNextPage']= $ifDisplayNextPage;
        $this->page['items']= $data;
        $this->page['musics']= json_encode($musics);


    }

    public function onAudio()
    {
        $id=post('id');
        $data=  $this->api->format(true)->url($id);

        $data=json_decode($data,true);


        return $data;
    }
}
