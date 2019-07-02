<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 11:55
 */
namespace Jc91715\Music\Classes;

interface MusicInterface
{
    public function downloadMp3($id);
    public function downloadImg($id);
    public function downloadLrc($id);
}
