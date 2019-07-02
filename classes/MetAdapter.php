<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 12:18
 */

namespace Jc91715\Music\Classes;

use Metowolf\Meting as Met;

class MetAdapter implements MusicAdapterInterface
{
    protected static $suppose=array('netease', 'tencent', 'xiami', 'kugou', 'baidu');
    protected static $defaultPingtai='netease';
    protected $api;
    public function __construct()
    {
        $pingtai = request()->get('pingtai',self::$defaultPingtai);
        if(!in_array($pingtai,self::$suppose)){
            $pingtai='netease';
        }

        $this->api = new Met($pingtai);
    }

    public function mp3Url($id)
    {
        $data= $this->api->format(true)->url($id);
        $data=json_decode($data,true);
        return $data['url'];
    }

    public function imgUrl($id)
    {
        $data= $this->api->format(true)->pic($id);
        $data=json_decode($data,true);
        return $data['url'];
    }

    public function lrcData($id)
    {
        $data= $this->api->format(true)->lyric($id);
        $data=json_decode($data,true);
        return $data['lyric'];
    }
}
