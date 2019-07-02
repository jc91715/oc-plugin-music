<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Jc91715\Music\Classes\MusicAdapterInterface;

class Meting extends ComponentBase
{
    protected $api;
    public $downPage;
    public $pingTai;

    public $search;
    public $page;
    public $nextPage;
    public $ifDisplayNextPage;
    public $musics;




    public function componentDetails()
    {
        return [
            'name'        => 'meting Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'downPage' => [
                'title' => '下载页',
                'type' => 'dropdown',
                'default' => 'download'
            ],
            'limit'=>[
                'title' => '每一页显示',
                'type' => 'dropdown',
                'default' => '10'
            ]
        ];
    }
    public function getDownPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getLimitOptions()
    {
        $arr=[];

        foreach (range(1,50) as $v1){
            $arr[$v1]=$v1;
        }
        return $arr;
    }
    public function init()
    {

       $this->downPage = $this->property('downPage');
       $this->api = app(MusicAdapterInterface::class);
       $this->pingTai =  $this->api->getPingtai();

    }

    public function onRun()
    {
        $this->addCss('assets/css/APlayer.min.css');
        $this->addJs('assets/js/APlayer.min.js');



//       $api = new Met('netease');
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
        $options = [
            'page' => $page,
            'limit' => $this->property('limit')
        ];
        $data = $this->api->search($search,$options);
        $musics = $this->api->transformSearchData($data,$this->downPage);

        //是否显示下一页
        $count=count($musics);
        $ifDisplayNextPage=true;
        if($count<$this->property('limit')){
            $ifDisplayNextPage=false;
        }

        $this->search= $search;
        //上一页
        $this->page= $page-1;
        //下一页
        $this->nextPage= $page+1;
        $this->ifDisplayNextPage= $ifDisplayNextPage;

        //音乐数据
        $this->musics= $musics;

    }

}
