<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_store',array('id'=>$_GPC['id']));
$coordinates=explode(',',$item['coordinates']);
   $item['coordinates']=array(
         'lat'=>$coordinates['0'],
         'lng'=>$coordinates['1'],
      );
if(checksubmit('submit')){
   $data['coordinates']=$_GPC['op']['lat'].','.$_GPC['op']['lng'];
      $data['md_img']=$_GPC['md_img'];
      $data['name']=$_GPC['name'];
      $data['address']=$_GPC['address'];
      $data['num']=$_GPC['num'];
      $data['sentiment']=$_GPC['sentiment'];
      $data['appid']=$_GPC['appid'];
      $data['xcx_name']=$_GPC['xcx_name'];
      $data['type']=2;
      $data['uniacid']=$_W['uniacid'];
       if($_GPC['id']==''){  
        $res=pdo_insert('zhvip_store',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('storead'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhvip_store',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('storead'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }

}

include $this->template('web/addstoread');