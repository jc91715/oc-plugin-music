<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:27
 */

namespace Jc91715\Music\Classes;


class ImgDownload extends MusicRequestAndDownload
{

    protected function headerType()
    {
        $path_parts  = pathinfo($this->url);
        $fileName= $path_parts['basename'];
        header("Accept-Ranges:bytes");
        header("Accept-Length:".strlen($this->fileData));
        header("Content-Disposition:attachment;filename=".$fileName);
    }

}
