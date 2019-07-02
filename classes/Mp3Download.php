<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:27
 */

namespace Jc91715\Music\Classes;


class Mp3Download extends MusicRequestAndDownload
{

    protected function headerType()
    {
        $path_parts  = pathinfo($this->url);
        $fileName= $path_parts['basename'];
        if(request()->get('file_name')){
            $fileName= request()->get('file_name').'.mp3';
        }
        header("Content-type:audio/mpeg");
        header("Accept-Ranges:bytes");
        header("Accept-Length:".strlen($this->fileData));
        header("Content-Disposition:attachment;filename=".$fileName);
    }

}
