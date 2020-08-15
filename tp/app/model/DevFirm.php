<?php


namespace app\model;
use think\Model;

class DevFirm extends Model
{
   public function multiDev()
   {
       return $this->hasMany(MultiDev::class,'devc_id');
   }
}