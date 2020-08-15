<?php


namespace app\controller\first;


use app\BaseController;
use app\model\Developer;
use app\model\DevFirm;
use app\model\District;
use app\model\Lpan;
use app\model\ProCom;
use app\model\ProEntity;
class ListModel extends BaseController
{
   public function getAll(){
       $lpanList = Lpan::order('update_time','desc')->order('id','asc')->field('id,register_name,ad_name,med_single_price,med_total_price,developers,property_company,position','area')->limit(10)->cursor();

       $result = array();
       foreach($lpanList as $lpan){
           //dump($register->toArray());
          // echo $register->lp_id;
           $row = array();

          // dump($lpan->toArray());
           $row['id'] = $lpan['id'];
           $row['register_name'] = $lpan['register_name'];
           $row['ad_name'] = $lpan['ad_name'];
           $row['med_single_price'] = $lpan['med_single_price'];
           $row['med_total_price'] = $lpan['med_total_price'];

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
           $row['position'] = $lpan['position'];
           array_push($result,$row);
           dump($row);
           
       }
       dump(json_encode($result,JSON_UNESCAPED_UNICODE));
   }

}