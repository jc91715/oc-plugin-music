<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:58
 */

namespace Jc91715\Music\Classes;



class Music implements MusicInterface
{


    public function downloadMp3($id)
    {
        $url = app(MusicAdapterInterface::class)->mp3Url($id);
        app()->make(Mp3Download::class)->download($url);
    }
    public function downloadImg($id)
    {
        $url = app(MusicAdapterInterface::class)->imgUrl($id);
        app()->make(ImgDownload::class)->download($url);
    }
    public function downloadLrc($id)
    {
        $data = app(MusicAdapterInterface::class)->lrcData($id);
        app()->make(LrcDownload::class)->downloadBydata($data);
    }
}
