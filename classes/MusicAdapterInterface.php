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


    public function mp3Url($id,$state);
    public function imgUrl($id,$state);
    public function lrcData($id,$state);
    public function getPingtai();
    public function search($search,$options);
    public function transformSearchData($data,$downPage);

}
