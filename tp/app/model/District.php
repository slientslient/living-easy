<?php


namespace app\model;


use think\Model;

class District extends Model
{
   public function lpan()
   {
       return $this->hasMany(Lpan::class,'area')->order('update_time','desc')->order('id','asc')->field('id,register_name,ad_name,med_single_price,med_total_price,developers,property_company,area,position');
   }
}