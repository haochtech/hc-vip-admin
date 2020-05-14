<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_user',array('id'=>$_GPC['id']));
$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid']));
$ordernum=count(pdo_getall('zhvip_order',array('user_id'=>$_GPC['id'],'state'=>2)));
$order = "select sum(money) as total from " . tablename("zhvip_order")." WHERE user_id=".$_GPC['id']." and state=2";
$order = pdo_fetch($order);//今天的充值
if(checksubmit('submit')){
      if($item['grade']!=$_GPC['grade'] and $_GPC['grade']){
            $data['grade']=$_GPC['grade']; 
            $data['code_time']=time(); 
            if(!$item['vip_code']){
                 $data['vip_code'] =str_shuffle(date('YmdHis').rand(1111,9999));
                 $num="0000000".$_GPC['id'];
                 $data['vip_number'] =substr($num, -6);
            }
      }
      if($_GPC['grade']!=$item['grade']){
        $data['level_cumulative']=0.00;
      }
      $data['name']=$_GPC['name'];
      $data['tel']=$_GPC['tel'];
      $data['birthday']=$_GPC['birthday'];
      $data['address']=$_GPC['address'];
      $data['email']=$_GPC['email'];
      $data['education']=$_GPC['education'];
      $data['industry']=$_GPC['industry'];
    $data['vip_time']=strtotime($_GPC['vip_time']);
      $data['hobby']=$_GPC['hobby'];
      $data['note']=$_GPC['note'];
      $res=pdo_update('zhvip_user',$data,array('id'=>$_GPC['id']));
      if($res){
         message('修改成功！', $this->createWebUrl('user'), 'success');
      }else{
         message('修改失败！','','error');
      }
}

include $this->template('web/adduser');