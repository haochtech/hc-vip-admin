<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$certfile = IA_ROOT . "/addons/zh_vip/cert/" . 'apiclient_cert_' .$_W['uniacid'] . '.pem';
$keyfile = IA_ROOT . "/addons//zh_vip/cert/" . 'apiclient_key_' . $_W['uniacid'] . '.pem';
$item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
        file_put_contents($certfile, trim($_GPC['apiclient_cert']));
        file_put_contents($keyfile, trim($_GPC['apiclient_key']));
        $data['mchid']=trim($_GPC['mchid']);
        $data['wxkey']=trim($_GPC['wxkey']);
        $data['uniacid']=$_W['uniacid'];
        $data['apiclient_cert']=$_GPC['apiclient_cert'];
            $data['apiclient_key']=$_GPC['apiclient_key']; 
        $data['is_yue']=$_GPC['is_yue'];
         $data['is_jfpay']=$_GPC['is_jfpay'];
         if($_GPC['jf_proportion']<=0){
            message('积分支付比例不能小于等于零!','','error');
         }
         $data['jf_proportion']=$_GPC['jf_proportion'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('pay',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('pay',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/pay');