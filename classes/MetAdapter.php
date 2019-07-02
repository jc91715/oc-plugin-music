<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 12:18
 */

namespace Jc91715\Music\Classes;

use Metowolf\Meting as Met;
use Cms\Classes\Page;

class MetAdapter implements MusicAdapterInterface
{
    protected static $suppose=array('netease', 'tencent', 'xiami', 'kugou', 'baidu');
    protected static $defaultPingtai='netease';
    protected $pingTai;
    protected $api;
    public static $sourceMaps= [
        'netease'=>'网易', 'tencent'=>'腾讯', 'xiami'=>'虾米', 'kugou'=>'酷狗', 'baidu'=>'百度'];
    public function __construct()
    {
        $pingtai = request()->get('pingtai',self::$defaultPingtai);
        if(!in_array($pingtai,self::$suppose)){
            $pingtai='netease';
        }
        $this->pingTai= $pingtai;
        $this->api = new Met($pingtai);
    }

    public function mp3Url($id,$state=false)
    {
        $data= $this->api->format(true)->url($id);
        $data=json_decode($data,true);
        if($state){
            return $data;
        }
        return $data['url'];
    }

    public function imgUrl($id,$state=false)
    {
        $data= $this->api->format(true)->pic($id);
        $data=json_decode($data,true);
        if($state){
            return $data;
        }
        return $data['url'];
    }

    public function lrcData($id,$state=false)
    {
        $data= $this->api->format(true)->lyric($id);
        $data=json_decode($data,true);
        if($state){
            return $data;
        }
        return $data['lyric'];
    }
    public function getPingtai()
    {
        return $this->pingTai;
    }

    public function search($search,$options)
    {
        $data = $this->api->format(true)->search($search, $options);
        $data=json_decode($data,true);

        return $data;

    }

    public function transformSearchData($data,$downPage)
    {
        $musics=[];
        foreach ($data as $v){
            $music=[];
            $music['id']= $v['id'];
            $music['source']= self::$sourceMaps[$v['source']];
            $music['name']= $v['name'];
            $music['artist']= implode(',',$v['artist']);
            $music['url']= Page::url($downPage,['id'=>$v['id'],'type'=>'mp3']).'?file_name'.$v['name'].'&pingtai='.$this->pingTai;
            $music['lrc']= Page::url($downPage,['id'=>$v['id'],'type'=>'lrc']).'?pingtai='.$this->pingTai;
            $music['cover']= Page::url($downPage,['id'=>$v['id'],'type'=>'img']).'?pingtai='.$this->pingTai;
            $musics[]=$music;
        }
        return $musics;
    }
}
