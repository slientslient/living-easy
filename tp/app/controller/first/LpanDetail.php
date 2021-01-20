<?php


namespace app\controller\first;

use app\controller\first\Send;
use app\BaseController;
use app\model\Developer;
use app\model\DevFirm;
use app\model\District;
use app\model\RoomNum;
use app\model\Ldong;
use app\model\Lpan;
use app\model\MultiDev;
use app\model\ProCom;
use app\model\ProEntity;
use app\model\Register;
use think\facade\Db;
use think\facade\Request;

class LpanDetail extends BaseController
{
    use Send;
    public function getDetail(){
        $id = Request::param('id');
        $lpan = Lpan::where('id','=',$id)->find();
        //dump($register->toArray());
        // echo $register->lp_id;
        $row = array();
        // dump($lpan->toArray());
        $row['id'] = $lpan['id'];
        $row['register_name'] = $lpan['register_name'];
        $row['ad_name'] = $lpan['ad_name'];
        $row['position'] = $lpan['position'];
        $row['med_single_price'] = $lpan['med_single_price'];
        $row['med_total_price'] = $lpan['med_total_price'];
        $sdata=array();
        array_push($sdata,$lpan['count_first_price']);
        array_push($sdata,$lpan['count_second_price']);
        array_push($sdata,$lpan['count_third_price']);
        array_push($sdata,$lpan['count_forth_price']);
        array_push($sdata,$lpan['count_fifth_price']);
        $row['sdata'] = $sdata;
        $stdata =array();
        array_push($stdata,$lpan['count_first_area']);
        array_push($stdata,$lpan['count_second_area']);
        array_push($stdata,$lpan['count_third_area']);
        array_push($stdata,$lpan['count_forth_area']);
        array_push($stdata,$lpan['count_fifth_area']);
        $row['stdata'] = $stdata;

        //查询区域
        $area = District::where('id','=',$lpan['area'])->find();
        $row['area'] = $area['name'];
        $devCom = DevFirm::where('id','=',$lpan['developers'])->field('id,name')->find();
        //dump($devCom->toArray());
        $row['devc_name'] = $devCom['name'];
        $devlist = MultiDev::where('devc_id','=',$devCom['id'])->select();
        // dump($devlist->toArray());
        //将开发实体对应的多个开发商名字查询出来
        $res= array();
        foreach($devlist as $dev){
            $devName = Developer::where('id','=',$dev['dev_id'])->field('name')->find();
            // dump($devName->toArray());
            array_push($res,$devName['name']);
        }

        $row['dev_name'] = $res;
        $proEntity = ProEntity::where('id','=',$lpan['property_company'])->field('name,simple_id')->find();
        //dump($proEntity->toArray());
        $row['proc_name'] = $proEntity['name'];
        $proShort = ProCom::where('id','=',$proEntity['simple_id'])->find();
        //dump($proShort);
        $row['pro_short'] = $proShort['name'];

        $row['capacity_rate'] = $lpan['capacity_rate'];
        $row['land_area'] = $lpan['land_area'];
        $row['greening_rate'] = $lpan['greening_rate'];
        $row['parking_rate'] = $lpan['parking_rate'];
        $ldongList = Db::name('register')->alias('r')->join('ldong ld','ld.reg_id=r.id')->where('ld.lp_id','=',$id)->order('r.reg_name','desc')->select();
        //$ldongList = Ldong::where('lp_id','=',$id)->order('gen_time','desc')->order('id','asc')->cursor();
        $ldResult = array();
        foreach($ldongList as $ldong){
            $ldrow = array();
            $ldrow['id'] = $ldong['id'];
            $ldrow['ld_name'] = $ldong['ld_name'];
            $ldrow['med_total_price'] = $ldong['总价范围'];
            $ldrow['med_single_price'] = $ldong['单价范围'];
            $ldrow['med_area'] = $ldong['面积范围'];
            $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
            $ldrow['reg_name'] = $reg_name['reg_name'];
            $floor_family_num = RoomNum::where('ld_id','=',$ldong['id'])->count();
            $ldrow['floor_family_num'] = $floor_family_num;
            $ldrow['floor_num'] = $ldong['floor_num'];
            $ldrow['gen_time'] = $ldong['gen_time'];
            array_push($ldResult,$ldrow);
        }
        $row['ldong_list']=$ldResult;
        //$row['ldong_list']=$ldResult;
        //dump($row);

       // dump(json_encode($row,JSON_UNESCAPED_UNICODE));
        self::returnMsg('200','sucess',$row);
    }

    public function sort()
    {
        $way = Request::param('way');
        $lp_id = Request::param('lp_id');
        $ldongList = Db::name('register')->alias('r')->join('ldong ld','ld.reg_id=r.id')->where('ld.lp_id','=',$lp_id)->order('r.reg_name','desc')->select();
        //$ldongList = Ldong::where('lp_id','=',$lp_id)->order('gen_time','desc')->order('id','asc')->cursor();
        if($way == 2){
            $ldongList = Ldong::where('lp_id','=',$lp_id)->order('floor_num','asc')->cursor();

        }else if($way == 3){
            $ldongList = Ldong::where('lp_id','=',$lp_id)->order('floor_num','desc')->cursor();
            $orderWay = 'floor_num';
        }else if($way == 4){
            $ldongList = Ldong::where('lp_id','=',$lp_id)->order('order_params','asc')->cursor();

        }else if($way == 5) {
            $ldongList = Ldong::where('lp_id', '=', $lp_id)->order('order_params', 'desc')->cursor();

        }
        $ldResult = array();
        foreach($ldongList as $ldong){
            $ldrow = array();
            $ldrow['id'] = $ldong['id'];
            $ldrow['ld_name'] = $ldong['ld_name'];
            $ldrow['med_total_price'] = $ldong['总价范围'];
            $ldrow['med_single_price'] = $ldong['单价范围'];
            $ldrow['med_area'] = $ldong['面积范围'];
            $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
            $ldrow['reg_name'] = $reg_name['reg_name'];
            $floor_family_num = RoomNum::where('ld_id','=',$ldong['id'])->count();
            $ldrow['floor_family_num'] = $floor_family_num;
            $ldrow['floor_num'] = $ldong['floor_num'];
            $ldrow['ld_prefix'] = $ldong['ld_prefix'];
            $ldrow['ld_num'] = $ldong['ld_num'];
            $ldrow['gen_time'] = $ldong['gen_time'];
            array_push($ldResult,$ldrow);
        }
        //dump(json_encode($ldResult,JSON_UNESCAPED_UNICODE));
        self::returnMsg('200','sucess',$ldResult);
    }
}