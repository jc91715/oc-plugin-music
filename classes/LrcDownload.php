<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:27
 */

namespace Jc91715\Music\Classes;


class LrcDownload extends MusicRequestAndDownload
{

    protected function headerType()
    {
        header("Content-type:text/html; charset=UTF-8");
        header("Accept-Length:".strlen($this->fileData));
    }


}
