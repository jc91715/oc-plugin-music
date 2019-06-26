<?php namespace Jc91715\Music\Components;

use Cms\Classes\ComponentBase;
use Metowolf\Meting as Met;

class Meting extends ComponentBase
{
    protected $api;
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
    }

    public function onRun()
    {

//       $api = new Met('netease');
// Use custom cookie (option)
// $api->cookie('paste your cookie');

// Get data
//        $data = $api->format(true)->search('朋友', [
//            'page' => 1,
//            'limit' => 50
//        ]);
//        $data= $api->format(true)->url(26397012);
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
        foreach ($data as &$v){
            $v['artist'] = implode(',',$v['artist']);
        }
        $count=count($data);
        $ifDisplayNextPage=true;
        if($count<10){
            $ifDisplayNextPage=false;
        }
        $this->page['search']= $search;
        $this->page['page']= $page;
        $page++;
        $this->page['nextPage']= $page;
        $this->page['ifDisplayNextPage']= $ifDisplayNextPage;
        $this->page['items']= $data;
        \Flash::success('获取数据成功');
//        $this->renderPartial('search');

    }

    public function onAudio()
    {
        $id=post('id');
        $data=  $this->api->format(true)->url($id);

        $data=json_decode($data,true);


        return $data;
    }
}
