<?php


namespace app\controller;


use think\exception\ErrorException;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Log;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Store
{
    public function session()
    {
        Session::set('user','Mr.Lee');
        Session::set('count','se');
        //return Session::get('user');
        //return json(Session::all());
        //dump(Request::session('user'));
        //dump(Request::session());
        //dump(Session::get('name','null'));

        //Session::flash('value',200);
    }
    public function cookie(){
        //Cookie::set('user','Mr.Lee');

    }
    public function cache(){
        Cache::set('user','Mr.Lee');
        dump(Cache::get('user'));
    }
    public function redis(){
        Cache::set('user','Mr.Wang',3600);
        dump(Cache::get('user'));
    }
    public function log()
    {
        //Log::record('测试日志');
//        Log::record('错误日志','error');
//        Log::close();
        try{
            echo 0/0;
        }catch(ErrorException $e){
            echo $e->getMessage();
            Log::record('被除数不能为零','error');
        }

    }
    public function middleware()
    {
        View::fetch('middleware');
    }
    public function get(){
        //return Session::get('value');
    }
}