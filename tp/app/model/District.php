<?php


namespace app\model;


use think\Model;

class District extends Model
{
   public function lpan()
   {
       return $this->hasMany(Lpan::class,'area')->order('update_time','desc')->order('id','asc');
   }
}