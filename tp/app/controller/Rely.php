<?php


namespace app\controller;
use think\facade\Request;

class Rely
{
//    /**
//     * @var \think\Request Request实例
//     */
//    protected $request;
//
//    /**
//     * 构造方法
//     * @param Request $request Request对象
//     * @access public
//     */
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }
//
//    public function index()
//    {
//        return $this->request->param('username');
//    }
//    public function index(Request $request)
//    {
//        return $request->param('username');
//    }
      public function index(){

          dump(Request::param('username')) ;

          dump(Request::get('dump(Request::get(\'username\'));'));

          dump(Request::route('username'));

      }
      public function get(){
          dump(Request::isGet()) ;
          dump(Request::isPost());
          dump(Request::method());
      }
}