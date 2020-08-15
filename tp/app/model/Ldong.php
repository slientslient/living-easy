<?php


namespace app\model;


use think\Model;

class Ldong extends Model
{
    public function houseType()
    {
        return $this->hasMany(HouseType::class,'ld_id');
    }

}