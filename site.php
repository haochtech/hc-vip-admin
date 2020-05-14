<?php


defined('IN_IA') or exit('Access Denied');

require 'inc/func/core.php';

class Zh_vipModuleSite extends Core {

     public function doMobileDelUser(){
        global $_W,$_GPC;
        $res=pdo_delete('zhvip_user',array('id'=>$_GPC['id']));
        pdo_delete('zhvip_order',array('user_id'=>$_GPC['id']));
        pdo_delete('zhvip_usercoupons',array('user_id'=>$_GPC['id']));
        
         if($res){
            echo '1';
        }else{
            echo '2';
        }
    }
    public function doMobileDelStore(){
        global $_W,$_GPC;
        $res=pdo_delete('zhvip_store',array('id'=>$_GPC['id']));
         if($res){
            echo '1';
        }else{
            echo '2';
        }
    }

    //删除充值活动
    public function doMobileDelCz(){
        global $_W,$_GPC;
        $res=pdo_delete('zhvip_czhd',array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }
    }
    //添加充值活动
    public function doMobileAddCz(){
        global $_W,$_GPC;
        for($i=0;$i<count($_GPC['list']);$i++){
            $data['full']=$_GPC['list'][$i]['full'];
            $data['reduction']=$_GPC['list'][$i]['reduction'];
            $data['uniacid']=$_W['uniacid'];
            pdo_insert('zhvip_czhd',$data);
        }
    }

    //商家分类批量删除
public function doMobileDeletefenlei(){
    global $_W, $_GPC;
        $res=pdo_delete('zhvip_type',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('fenlei',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家分类批量启用
public function doMobileQyfenlei(){
     global $_W, $_GPC;
        $res=pdo_update('zhvip_type',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('fenlei',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//商家分类批量禁用
public function doMobileJyfenlei(){
     global $_W, $_GPC;
        $res=pdo_update('zhvip_type',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('fenlei',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


 //查询商家二级分类
    public function doMobileGetStoreType() {
        global $_W,$_GPC;
         $type2=pdo_getall('zhvip_type2',array('type_id'=>$_GPC['id']));
         echo json_encode($type2);

    }
    //添加商品
    public function doMobileAddGood(){
        global $_W,$_GPC;
        $data['name']=$_GPC['goodname'];
        $data['t_id']=$_GPC['fenlei'];
        $data['type_id']=$_GPC['erflval'];
        $data['logo']=$_GPC['logo'];
        $data['money']=$_GPC['flshou'];
        $data['money2']=$_GPC['flyuan'];
        $data['img']=implode(",",$_GPC['huanurl']);
        $data['is_show']=$_GPC['statu'];
        $data['inventory']=$_GPC['flstock'];
        $data['details']=html_entity_decode($_GPC['viewval']);
        $data['store_id']=$_GPC['storeid'];
        $data['sales']=$_GPC['flxiao'];
        $data['num']=$_GPC['numpai'];
        $data['is_gg']=$_GPC['checkval'];
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('zhvip_goods',$data);
        $good_id=pdo_insertid();
        for($i=0;$i<count($_GPC['list']);$i++){
            $data2['name']=$_GPC['list'][$i]['color'];
            $data2['good_id']=$good_id;
            $data2['num']=$i;
            $data2['uniacid']=$_W['uniacid'];
            pdo_insert('zhvip_spec',$data2);
            $specid=pdo_insertid();
            for($k=0;$k<count($_GPC['list'][$i]['ggarr']);$k++){
                $data3['name']=$_GPC['list'][$i]['ggarr'][$k]['guigebig'];
                $data3['spec_id']=$specid;
                $data3['num']=$k;
                $data3['uniacid']=$_W['uniacid'];
                $data3['good_id']=$good_id;
                pdo_insert('zhvip_spec_val',$data3);
            }
        }

        for($j=0;$j<count($_GPC['menu']);$j++){
            $data4['combination']='';
            for($l=0;$l<(count($_GPC['menu'][$j]['biao'])-2);$l++){
                    $data4['combination'] .=$_GPC['menu'][$j]['biao'][$l]['inpval'].",";
            }
             $data4['combination']=substr($data4['combination'],0,strlen($data4['combination'])-1); 
        //   $data4['combination']=$_GPC['menu'][$j]['biao'][0]['inpval'].','.$_GPC['menu'][$j]['biao'][1]['inpval'];
            $count=count($_GPC['menu'][$j]['biao'])-1;
            $count2=count($_GPC['menu'][$j]['biao'])-2;
            $data4['money']=$_GPC['menu'][$j]['biao'][$count]['inpval'];
            $data4['number']=$_GPC['menu'][$j]['biao'][$count2]['inpval'];
            $data4['good_id']=$good_id;
            pdo_insert("zhvip_spec_combination",$data4);
        }



    }
    //修改商品
    public function doMobileUpdGood(){
       global $_W,$_GPC;
      // echo $_GPC['fenlei'];die;
      pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
        if($_GPC['scid']){
            pdo_delete('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
            pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
          for($t=0;$t<count($_GPC['scid']);$t++){
            pdo_delete('zhvip_spec',array('id'=>$_GPC['scid'][$t]['id']));
            pdo_delete('zhvip_spec_val',array('spec_id'=>$_GPC['scid'][$t]['id']));    
          }  
        }
        if($_GPC['smallid']){
            pdo_delete('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
            pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
            for($y=0;$y<count($_GPC['smallid']);$y++){
            pdo_delete('zhvip_spec_val',array('id'=>$_GPC['smallid'][$y]['id']));  
        }  
        }
        $data['name']=$_GPC['goodname'];
        $data['t_id']=$_GPC['fenlei'];
        $data['type_id']=$_GPC['erflval'];
        $data['logo']=$_GPC['logo'];
        $data['money']=$_GPC['flshou'];
        $data['money2']=$_GPC['flyuan'];
        if($_GPC['huanurl']){
           $data['img']=implode(",",$_GPC['huanurl']); 
        }
        
        $data['is_show']=$_GPC['statu'];
        $data['inventory']=$_GPC['flstock'];
        $data['details']=html_entity_decode($_GPC['viewval']);
        $data['store_id']=$_GPC['storeid'];
        $data['sales']=$_GPC['flxiao'];
        $data['num']=$_GPC['numpai'];
        $data['is_gg']=$_GPC['checkval'];
        if($_GPC['checkval']==1){
            pdo_delete('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
            pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
            pdo_delete('zhvip_spec_val',array('good_id'=>$_GPC['good_id']));
            pdo_delete('zhvip_spec',array('good_id'=>$_GPC['good_id']));
        }
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_update('zhvip_goods',$data,array('id'=>$_GPC['good_id']));   
        for($i=0;$i<count($_GPC['list']);$i++){
        	if(isset($_GPC['list'][$i]['coid'])){
        		pdo_update('zhvip_spec',array('name'=>$_GPC['list'][$i]['color']),array('id'=>$_GPC['list'][$i]['coid']));
        	}else{
                pdo_delete('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
                pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
        		pdo_insert('zhvip_spec',array('name'=>$_GPC['list'][$i]['color'],'good_id'=>$_GPC['good_id'],'num'=>$i,'uniacid'=>$_W['uniacid']));
        		$specid=pdo_insertid();
        	}
            
            for($j=0;$j<count($_GPC['list'][$i]['ggarr']);$j++){
            	if(is_numeric($_GPC['list'][$i]['ggarr'][$j]['shuid'])){
            		pdo_update('zhvip_spec_val',array('name'=>$_GPC['list'][$i]['ggarr'][$j]['guigebig']),array('id'=>$_GPC['list'][$i]['ggarr'][$j]['shuid']));
            	}else{
                    if($_GPC['list'][$i]['coid']){
                        $spec_id=$_GPC['list'][$i]['coid'];
                    }else{
                        $spec_id=$specid;
                    }
                    pdo_delete('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
                    pdo_delete('zhvip_shopcar',array('good_id'=>$_GPC['good_id']));
                 	pdo_insert('zhvip_spec_val',array('name'=>$_GPC['list'][$i]['ggarr'][$j]['guigebig'],'spec_id'=>$spec_id,'num'=>$j,'uniacid'=>$_W['uniacid'],'good_id'=>$_GPC['good_id']));
            	}
            }
        }
        for($k=0;$k<count($_GPC['menu']);$k++){
             $data4['combination']='';
            for($l=0;$l<(count($_GPC['menu'][$k]['biao'])-2);$l++){
                    $data4['combination'] .=$_GPC['menu'][$k]['biao'][$l]['inpval'].",";
            }
            $data4['combination']=substr($data4['combination'],0,strlen($data4['combination'])-1); 
            $count=count($_GPC['menu'][$k]['biao'])-1;
            $count2=count($_GPC['menu'][$k]['biao'])-2;
            $data4['money']=$_GPC['menu'][$k]['biao'][$count]['inpval'];
            $data4['number']=$_GPC['menu'][$k]['biao'][$count2]['inpval'];
            $data4['good_id']=$_GPC['good_id'];
            if(isset($_GPC['menu'][$k]['id'])){
            	pdo_update("zhvip_spec_combination",$data4,array('id'=>$_GPC['menu'][$k]['id']));
            }else{
            	pdo_insert("zhvip_spec_combination",$data4);
            }
            
        }

    }
    //批量删除商品
    public function doMobileDelGoods(){
        global $_W,$_GPC;
        $res=pdo_delete("zhvip_goods",array('id'=>$_GPC['id']));
         if($res){
            pdo_delete("zhvip_shopcar",array('good_id'=>$_GPC['id']));
            pdo_delete("zhvip_spec_combination",array('good_id'=>$_GPC['id']));
            pdo_delete("zhvip_spec_val",array('good_id'=>$_GPC['id']));
            message('删除成功！', $this->createWebUrl('goods'), 'success');
          }else{
            message('删除失败！','','error');
          }
    }
    //批量下架
    public function doMobileXjGoods(){
        global $_W,$_GPC;
        $res=pdo_update("zhvip_goods",array('is_show'=>2),array('id'=>$_GPC['id']));
    }
     //批量上架
    public function doMobileSjGoods(){
        global $_W,$_GPC;
        $res=pdo_update("zhvip_goods",array('is_show'=>1),array('id'=>$_GPC['id']));
    }
    //查看商品详情
    public function doMobileGoodInfo(){
        global $_W,$_GPC;
        $type=pdo_getall('zhvip_spec',array('uniacid'=>$_W['uniacid'],'good_id'=>$_GPC['good_id']),array(),'','num ASC');
         $list=pdo_getall('zhvip_spec_val',array('uniacid'=>$_W['uniacid'],'good_id'=>$_GPC['good_id']),array(),'','num ASC');
         $data2=array();
         for($i=0;$i<count($type);$i++){
          $data=array();
          for($k=0;$k<count($list);$k++){
            if($type[$i]['id']==$list[$k]['spec_id']){
              $data[]=array(
                'id'=>$list[$k]['id'],
                'name'=>$list[$k]['name']
                );
            }           
          }
          $data2[]=array(
            'id'=>$type[$i]['id'],
            'sepc_name'=>$type[$i]['name'],
            'sepc_val'=>$data
            );
        }
        $combination=pdo_getall('zhvip_spec_combination',array('good_id'=>$_GPC['good_id']));
        $res['spec']=$data2;
        $res['combination']=$combination;
        echo json_encode($res);

}

//查找用户
public function doMobileFindGood(){
global $_W, $_GPC;
$sql =" select id,name from ".tablename('zhvip_goods')." where uniacid={$_W['uniacid']}  and name like '%{$_GPC['keywords']}%'";  
$user=pdo_fetchall($sql);
return json_encode($user);
}
//积分商品批量上架
public function doMobileJfGoodsSj(){
     global $_W, $_GPC;
        $res=pdo_update('zhvip_jfgoods',array('is_open'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('jfgoods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//积分商品批量下架
public function doMobileJfGoodsXj(){
     global $_W, $_GPC;
        $res=pdo_update('zhvip_jfgoods',array('is_open'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('jfgoods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//积分商品批量删除
public function doMobileDelJfGoods(){
     global $_W, $_GPC;
        $res=pdo_delete('zhvip_jfgoods',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('jfgoods',array()),'success');
        }else{
            message('删除失败','','error');
        }
}



public function  doMobileSelectUser(){
     global $_W, $_GPC;
     $sql =" select id,name from ".tablename('zhvip_user')." where uniacid={$_W['uniacid']}   and  (name like '%{$_GPC['keywords']}%' || openid like '%{$_GPC['keywords']}%') and name !='' and id not in (select admin_id from ".tablename('zhvip_store')." where uniacid={$_W['uniacid']})";  
     $user=pdo_fetchall($sql);
echo json_encode($user);

}












}