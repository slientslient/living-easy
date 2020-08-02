<?php


namespace app\controller;


use app\model\Lpan as LpanModel;

class DataModel
{
    public function index(){
        //return json(Lpan::select());
       // return json(LpanModel::find(2));

    }

    public function insert(){

    }
    public function getAttr(){
        $user = LpanModel::find(2);
        return  $user->developers;
    }
}