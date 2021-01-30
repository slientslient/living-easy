<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get('getAll','\app\controller\first\listModel::getAll');

Route::get('searchArea','\app\controller\first\search::byArea');

Route::get('searchName','\app\controller\first\search::byName');

Route::get('lpanDetail','\app\controller\first\lpanDetail::getDetail');

Route::get('ldongSort','\app\controller\first\lpanDetail::sort');

Route::get('ldongDetail','\app\controller\first\ldongDetail::getDetail');

Route::get('getNewRegister','\app\controller\first\secondIndex::getNewRegister');

Route::get('getKpiData','\app\controller\first\secondIndex::getKpiData');

Route::get('getChangeData','\app\controller\first\secondIndex::getChangeData');

