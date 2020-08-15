<?php


namespace app\controller;
use app\model\DevFirm;
use app\model\District;
use app\model\Lpan;


class Grade
{
   public function index()
   {
       $user = Lpan::find(3);
       return json($user->register);
   }
   //关联预载，减少查询，提高效率
    public function load()
    {
        $list = Lpan::with(['register'=>function($query){
            $query->field('lp_id,reg_name');//field必须写外键
        },'ldong'=>function($query){
            $query->field('lp_id,ld_name');
        }])->select([1,2,3]);
        foreach($list as $lp){
            dump($lp->register.$lp->ldong);
         }
    }

    public function area()
    {
        $list = District::find(1);
        return json($list->lpan);
    }
    public function dev(){
       $dev = DevFirm::find(1);
       return json($dev->multiDev);
    }

}