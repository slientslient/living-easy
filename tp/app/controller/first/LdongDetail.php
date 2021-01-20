<?php


namespace app\controller\first;


use app\controller\first\Send;
use app\model\Ldong;
use app\model\Register;
use app\model\Room;
use app\model\RoomNum;
use think\facade\Request;
use think\facade\Db;

class LdongDetail
{
    use Send;
    public function getDetail()
    {
        $id = Request::param('id');
        $ldong = Ldong::where('id','=',$id)->find();
        $ldResult = array();
        $ldrow['id'] = $ldong['id'];
        $ldrow['ld_name'] = $ldong['ld_name'];
        $ldrow['med_total_price'] = $ldong['总价范围'];
        $ldrow['med_single_price'] = $ldong['单价范围'];
        $ldrow['med_area'] = $ldong['面积范围'];
        $reg_name = Register::where('id','=',$ldong['reg_id'])->find();
        $ldrow['reg_name'] = $reg_name['reg_name'];
        $ldrow['family_num'] = $ldong['family_num'];
        $ldrow['floor_num'] = $ldong['floor_num'];

        //按照户型统计的数据
        //$typeList = $ldong->houseType;

        $typeList = RoomNum::where('ld_id','=',$id)->order('room_num','asc')->select();
        $typeListArray = array();
        foreach($typeList as  $item){
            $typeItem= array();
            $typeItem['room_num'] =$item['room_num'];
            $typeItem['avg_single_price'] = $item['avg_single_price'];
            $typeItem['med_single_price'] = $item['med_single_price'];
            $typeItem['med_area'] = $item['med_area'];
            $typeItem['med_total_price'] = $item['med_total_price'];
            array_push($typeListArray,$typeItem);
        }
        $typeItems= array();
        $typeItems['room_num'] = '整体';
        $typeItems['avg_single_price'] = $ldong['avg_single_price'];
        $typeItems['med_single_price'] = $ldong['med_single_price'];
        $typeItems['med_area'] = $ldong['med_area'];
        $typeItems['med_total_price'] = $ldong['med_total_price'];
        array_push($typeListArray,$typeItems);
        $ldrow['type_list'] = $typeListArray;

        $roomResult = array();
        $roomRow = array();

        $floor_level_min = Room::where('ld_id','=',$id)->min('floor_level');
        $floor_level_max = Room::where('ld_id','=',$id)->max('floor_level');
        $floor_index = $floor_level_max;
        $ldrow['max_level'] = $floor_level_max;
        $ldrow['min_level'] =  $floor_level_min ;
        while($floor_index >= $floor_level_min ){
            $roomRow = Room::where('ld_id','=',$id)->where('floor_level','=',$floor_index)
                ->order('room_num','asc')->field('id,room_name,floor_level,room_num,building_area,pub_area,inside_area,single_price,total_price,remark')->select();
           // dump($roomRow->toArray());
            array_push($roomResult,$roomRow);
            $floor_index  = $floor_index -1;
        }

        $ldrow['room_result'] = $roomResult;
        //dump(json_encode($ldrow,JSON_UNESCAPED_UNICODE));
        //特殊楼层
        $roomSArray = array();
        $roomSpecial = Db::name('room')->where('ld_id','=',$id)->where('floor_level',null)->field('room_name,building_area,pub_area,inside_area,single_price,total_price')->select();
        
        $ldrow['room_special'] = $roomSpecial;
        self::returnMsg('200','sucess',$ldrow);
    }

}