<?php namespace Jc91715\Music\Classes;
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:16
 */

abstract class MusicRequestAndDownload
{
    protected $url;
    protected $fileData;

    protected function request($url)
    {
        $this->url = $url;
        $this->fileData = file_get_contents($url);
    }

    abstract protected function headerType();

    public function downLoad($url){
       $this->request($url);
       $this->headerType();
       echo $this->fileData;
       exit();
    }

    public function downloadBydata($fileData)
    {
        $this->fileData=$fileData;
        $this->headerType();
        echo $this->fileData;
        exit();
    }

}
