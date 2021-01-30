<?php
namespace app\controller\first;
use app\BaseController;
use app\controller\first\Send;
use app\model\District;
use app\model\Lpan;
use app\model\Register;
use think\facade\Db;
use think\facade\Request;
use app\model\月报表;
use app\model\年报表;


class secondIndex extends BaseController{
    use Send;
    public function getNewRegister()
    {
        $area = Request::param('area');
        $areaRow = District::where('name','=',$area)->find();
        $regList = array();
        if($areaRow['id'] == 0){
            $regList = Db::name('register')->alias('r')->join('lpan lp','lp.id=r.lp_id')->order('r.gen_time','desc')->limit(5)->cursor();
        }else if($areaRow['id'] == 998){
            $regList = Db::name('register')->alias('r')->join('lpan lp','lp.id=r.lp_id')->where('lp.area','in',[10,11,12,13,14])->order('r.gen_time','desc')->limit(5)->cursor();
        }else if($areaRow['id'] == 999){
            $regList = Db::name('register')->alias('r')->join('lpan lp','lp.id=r.lp_id')->where('lp.area','in',[1,2,3,4,5,6,7,8,9])->order('r.gen_time','desc')->limit(5)->cursor();
        }else{
            $regList = Db::name('register')->alias('r')->join('lpan lp','lp.id=r.lp_id')->where('lp.area','=',$areaRow['id'])->order('r.gen_time','desc')->limit(5)->cursor();
        }

        $result = array();
        foreach ($regList as $reg) {
            $row = array();
            $lpname = $reg['ad_name'];
            $row['lpid'] = $reg['lp_id'];
            $row['lpname'] = $lpname;
            $row['ldname'] = $reg['ld_names'];
            $row['sets'] = $reg['reg_nums'];
            $row['price'] = $reg['avg_price'];
            $row['gen_time'] = $reg['gen_time'];
            array_push($result, $row);
        }
        self::returnMsg('200', 'sucess', $result);
    }


    public function getKpiData(){
        $area = Request::param('area');
        $time = Request::param('time');
        $tag = Request::param('tag');
        $areaRow = District::where('name','=',$area)->find();
        $searchResult = array();
        if($tag == 1){
            $searchResult =  月报表::where('区县','=',$areaRow['id'])->where('年月','=',$time)->select();
        }else{
            $searchResult =  年报表::where('区县','=',$areaRow['id'])->where('年','=',$time)->select();
        }

        $result= array();
        foreach($searchResult as $search){
            $row = array();
            $row['area'] = $search['备案面积'];
            $row['sets'] = $search['备案套数'];
            $row['totalPrice'] = $search['备案总价'];
            $row['singlePriceMiddle'] = $search['备案单价中位数'];
            $row['areaMiddle'] = $search['备案面积中位数'];
            $row['totalPriceMiddle'] = $search['备案总价中位数'];
            $row['updateTime'] = $search['更新时间'];
            array_push($result, $row);

        }
        self::returnMsg('200', 'sucess',$result);
    }

    public function getChangeData(){
        $area = Request::param('area');
        $tag = Request::param('tag');
        //$type = Request::param('type');
        $timemax = Request::param('timemax');
        $timemin = Request::param('timemin');
        $areaRow = District::where('name','=',$area)->find();
//        $filed = '';
//        if($type == 1){
//            $filed = '备案单价中位数';
//        }else if($type == 2){
//            $filed = '备案总价中位数';
//        }else if($type == 3){
//            $filed = '备案面积中位数';
//        }else if($type == 4){
//            $filed = '备案套数';
//        }else if($type == 5){
//            $filed = '备案总价';
//        }else if($type == 6){
//            $filed = '备案面积';
//        }
        $searchResult = array();
        if($tag == 1){
            $searchResult =  月报表::where('区县','=',$areaRow['id'])->where('年月','between',[$timemin,$timemax])->select();
        }else{
            $searchResult =  年报表::where('区县','=',$areaRow['id'])->where('年','between',[$timemin,$timemax])->select();
        }

        $result= array();
        foreach($searchResult as $search){
            $row = array();
            if($tag == 1){
                $row['timeFlag'] = $search['年月'];
            }else{
                $row['timeFlag'] = $search['年'];
            };
            $row['area'] = $search['备案面积'];
            $row['sets'] = $search['备案套数'];
            $row['totalPrice'] = $search['备案总价'];
            $row['singlePriceMiddle'] = $search['备案单价中位数'];
            $row['areaMiddle'] = $search['备案面积中位数'];
            $row['totalPriceMiddle'] = $search['备案总价中位数'];
            $row['updateTime'] = $search['更新时间'];
            array_push($result, $row);

        }
        self::returnMsg('200', 'sucess',$result);
    }
}