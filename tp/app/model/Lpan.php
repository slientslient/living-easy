<?php


namespace app\model;
use think\Model;
use app\model\DevFirm;

class Lpan extends Model
{
 //类名添加后缀需要设置模型名称
   // protected $name ='user';
//    protected static function init(){
//        //TODO:初始化内容
//    }
    //设置register_name修改器
//    public function getDevelpersAtrr($value){
//        $status = [1=>'删除',2=>'禁用',3=>'正常',4=>'待审核'];
//        return $status[$value];
//    }
    public function register(){
        return $this->hasMany(Register::class,'lp_id');
    }

    public function ldong(){
        return $this->hasMany(Ldong::class,'lp_id');
    }

}