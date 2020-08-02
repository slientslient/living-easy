<?php


namespace app\controller;


class Upload
{
    public function index()
    {
        $files = request()->file('image');
        // 上传到本地服务器
        $savename = [];
        foreach($files as $file){
            $savename[] = \think\facade\Filesystem::putFile( 'topic', $file);
        }
    }

    public function more()
    {
        $files = request()->file('image');
        $savename = [];
        foreach($files as $file){
            $savename[] = \think\facade\Filesystem::putFile( 'topic', $file);
        }
        dump($savename);
    }

}