<?php
namespace app\controller;
use app\BaseController;

class Test extends BaseController {
    public function index(){
        return 'index,方法名：'.$this->request->action().'当前实际路径：'.$this->app->getBasePath();
    }
    public function hello($value =''){
        return "hello!".$value;
    }
}
?>