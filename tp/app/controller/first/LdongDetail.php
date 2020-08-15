<?php


namespace app\controller\first;


use app\model\Ldong;
use app\model\Register;
use think\facade\Request;

class LdongDetail
{
    public function getDetail()
    {
        $id = Request::param('id');
        $ldong = Ldong::where('id','=',$id)->find();
        $ldResult = array();
        $ldrow['id'] = $ldong['id'];
        $ldrow['ld_name'] = $ldong['ld_name'];
        $ldrow['med_total_price'] = $ldong['med_total_price'];
        $ldrow['med_single_price'] = $ldong['med_single_price'];
        $ldrow['med_area'] = $ldong['med_area'];
        $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
        $ldrow['reg_name'] = $reg_name['reg_name'];
        $ldrow['family_num'] = $ldong['family_num'];
        $ldrow['floor_num'] = $ldong['floor_num'];

        //按照户型统计的数据
        $typeList = $ldong->houseType;
        $ldrow['type_list'] = $typeList;


        dump(json_encode($ldrow,JSON_UNESCAPED_UNICODE));
    }
}