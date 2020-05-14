<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$item=pdo_get('zhvip_mallset',array('uniacid'=>$_W['uniacid'],'store_id'=>$storeid));
if(checksubmit('submit')){
        $data['freight']=$_GPC['freight'];
        $data['full']=$_GPC['full'];
        $data['store_id']=$storeid;
        $data['uniacid']=$_W['uniacid'];
        $data['is_zt']=$_GPC['is_zt'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_mallset',$data);
                if($res){
                    message('添加成功',$this->createWebUrl2('dlmallset',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_mallset', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl2('dlmallset',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/dlmallset');