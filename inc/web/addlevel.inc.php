<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhvip_level',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
         $data['name']=$_GPC['name'];
        $data['img']=$_GPC['img'];
        // $data['my_img']=$_GPC['my_img'];
        $data['discount']=$_GPC['discount'];
        $data['details']=html_entity_decode($_GPC['details']);
         $data['level']=$_GPC['level'];
         $data['threshold']=$_GPC['threshold'];

         if(!$_GPC['name']){
           message('等级名称不能为空!','','error'); 
         }
         if(!$_GPC['discount']){
           message('等级折扣不能为空!','','error'); 
         }
         if(!$_GPC['level']){
           message('等级级别不能为空!','','error'); 
         }
         if(!$_GPC['threshold']){
           message('等级累计消费不能为空!','','error'); 
         }
        $data['uniacid']=$_W['uniacid'];
        if($_GPC['id']==''){  
            $list=pdo_get('zhvip_level',array('uniacid'=>$_W['uniacid'],'level'=>$_GPC['level']));
        if($list){
            message('已有该级别等级,请重新添加!','','error');
        }else{
          $res=pdo_insert('zhvip_level',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('level'), 'success');
        }else{
             message('添加失败！','','error');
        }  
        }
        
    }else{
        if($info['level']!=$_GPC['level']){
            $list=pdo_get('zhvip_level',array('uniacid'=>$_W['uniacid'],'level'=>$_GPC['level']));
            if($list){
                message('已有该级别等级,请重新编辑!','','error');
            }else{
            $res=pdo_update('zhvip_level',$data,array('id'=>$_GPC['id']));
                if($res){
                     message('编辑成功！', $this->createWebUrl('level'), 'success');
                }else{
                     message('编辑失败！','','error');
                }
            }
        }else{
            $res=pdo_update('zhvip_level',$data,array('id'=>$_GPC['id']));
                if($res){
                     message('编辑成功！', $this->createWebUrl('level'), 'success');
                }else{
                     message('编辑失败！','','error');
                }
        }
        

    } 
       
     
}
include $this->template('web/addlevel');