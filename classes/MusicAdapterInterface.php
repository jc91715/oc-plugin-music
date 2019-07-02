<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 2019/7/2
 * Time: 12:16
 */

namespace Jc91715\Music\Classes;


interface MusicAdapterInterface
{


    public function mp3Url($id);
    public function imgUrl($id);
    public function lrcData($id);

}
