<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;
use Metowolf\Meting as Met;
use Cms\Classes\Page;

class Meting extends ComponentBase
{
    protected $api;
    protected $downPage;
    protected $pingTai;

    public static $sourceMaps= [
        'netease'=>'网易', 'tencent'=>'腾讯', 'xiami'=>'虾米', 'kugou'=>'酷狗', 'baidu'=>'百度'];


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
        ];
    }
    public function getDownPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    public function init()
    {
        $suppose = array('netease', 'tencent', 'xiami', 'kugou', 'baidu');

        $pingtai = request()->get('pingtai','netease');
        if(!in_array($pingtai,$suppose)){
            $pingtai='netease';
        }

       $this->api = new Met($pingtai);
       $this->downPage = $this->property('downPage');
       $this->pingTai = $pingtai;
       $this->page['downPage'] = $this->property('downPage');
       $this->page['pingtai'] = $pingtai;

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


        $data = $this->api->format(true)->search($search, [
            'page' => $page,
            'limit' => 10
        ]);
        $data=json_decode($data,true);
        $musics = [];

        foreach ($data as &$v){
            $v['artist'] = implode(',',$v['artist']);
            $v['source'] = self::$sourceMaps[ $v['source']];
            $music=[];
            $music['name']= $v['name'];
            $music['artist']= $v['artist'];
            $music['url']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'mp3']).'?pingtai='.$this->pingTai;
            $music['lrc']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'lrc']).'?pingtai='.$this->pingTai;
            $music['cover']= Page::url($this->downPage,['id'=>$v['id'],'type'=>'img']).'?pingtai='.$this->pingTai;
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
