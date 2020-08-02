<?php


namespace app\controller;
use app\model\Lpan;
use think\facade\Db;

class DataTest
{
   public function index()
   {
      # $lp=Db::connect('mysql')->table('jby_lpan')->select();
       $dev = Db::name('dev_firm')->select();
       dump($dev);
//       $dev = Db::table('jby_dev_firm')->where('id','3')->value('name');
//       $mutil = Db::table('jby_dev_firm')->column('name','id');
//       return json($mutil);

   }
   public function getModelData(){
       $data = Lpan::select();
       #return json($data);
   }
}