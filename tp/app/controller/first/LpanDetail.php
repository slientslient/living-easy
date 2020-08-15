<?php


namespace app\controller\first;


use app\BaseController;
use app\model\Developer;
use app\model\DevFirm;
use app\model\District;
use app\model\Ldong;
use app\model\Lpan;
use app\model\ProCom;
use app\model\ProEntity;
use app\model\Register;
use think\facade\Request;

class LpanDetail extends BaseController
{
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
        $row['count_first_price'] = $lpan['count_first_price'];
        $row['count_second_price'] = $lpan['count_second_price'];
        $row['count_third_price'] = $lpan['count_third_price'];
        $row['count_forth_price'] = $lpan['count_forth_price'];
        $row['count_fifth_price'] = $lpan['count_fifth_price'];
        $row['count_first_area'] =$lpan['count_first_area'];
        $row['count_second_area'] =$lpan['count_second_area'];
        $row['count_third_area'] =$lpan['count_third_area'];
        $row['count_forth_area'] =$lpan['count_forth_area'];
        $row['count_fifth_area'] =$lpan['count_fifth_area'];

        //查询区域
        $area = District::where('id','=',$lpan['area'])->find();
        $row['area'] = $area['name'];
        $devCom = DevFirm::where('id','=',$lpan['developers'])->field('id,name')->find();
        //dump($devCom->toArray());
        $row['devc_name'] = $devCom['name'];
        $devlist = $devCom->multiDev;
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
        $ldongList = Ldong::where('lp_id','=',$id)->order('gen_time','desc')->order('id','asc')->cursor();
        $ldResult = array();
        foreach($ldongList as $ldong){
            $ldrow = array();
            $ldrow['id'] = $ldong['id'];
            $ldrow['ld_name'] = $ldong['ld_name'];
            $ldrow['med_total_price'] = $ldong['med_total_price'];
            $ldrow['med_single_price'] = $ldong['med_single_price'];
            $ldrow['med_area'] = $ldong['med_area'];
            $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
            $ldrow['reg_name'] = $reg_name['reg_name'];
            $ldrow['family_num'] = $ldong['family_num'];
            $ldrow['floor_num'] = $ldong['floor_num'];
            array_push($ldResult,$ldrow);
        }
        $row['ldong_list']=$ldResult;
        dump($row);

        dump(json_encode($row,JSON_UNESCAPED_UNICODE));
    }

    public function sort()
    {
        $way = Request::param('way');
        $lp_id = Request::param('lp_id');
        $orderWay = 'gen_time';
        if($way == 2){
            $orderWay = 'floor_num';
        }
        $ldongList = Ldong::where('lp_id','=',$lp_id)->order($orderWay,'desc')->order('id','asc')->cursor();
        $ldResult = array();
        foreach($ldongList as $ldong){
            $ldrow = array();
            $ldrow['id'] = $ldong['id'];
            $ldrow['ld_name'] = $ldong['ld_name'];
            $ldrow['med_total_price'] = $ldong['med_total_price'];
            $ldrow['med_single_price'] = $ldong['med_single_price'];
            $ldrow['med_area'] = $ldong['med_area'];
            $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
            $ldrow['reg_name'] = $reg_name['reg_name'];
            $ldrow['family_num'] = $ldong['family_num'];
            $ldrow['floor_num'] = $ldong['floor_num'];
            array_push($ldResult,$ldrow);
        }
        dump(json_encode($ldResult,JSON_UNESCAPED_UNICODE));
    }
}