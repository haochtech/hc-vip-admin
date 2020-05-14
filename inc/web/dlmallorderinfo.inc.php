<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"]; 
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu();
$item=pdo_get('zhvip_shoporder',array('id'=>$_GPC['id']));
$goods=pdo_getall('zhvip_ordergoods',array('order_id'=>$_GPC['id']));
if(checksubmit('submit')){
	$data['state']=$_GPC['state'];
	$data['money']=$_GPC['money'];
	$data['preferential']=$_GPC['preferential'];
	if($_GPC['dn_state']=="2"){
		$data['pay_time']=time();
	}
	$res=pdo_update('zhvip_shoporder',$data,array('id'=>$_GPC['id']));
	if($res){
             message('编辑成功！', $this->createWebUrl2('dlmallorderinfo',array('id'=>$_GPC['id'])), 'success');
        }else{
             message('编辑失败！','','error');
        }
}
if(checksubmit('submit3')){
    $res=pdo_update('zhvip_shoporder',array('state'=>3,'kd_num'=>$_GPC['reply'],'kd_name'=>$_GPC['reply2']),array('id'=>$_GPC['fh_id']));
    if($res){
        //////模板消息///////
        function getaccess_token($_W){
        $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true);
        return $data['access_token'];
    }
//设置与发送模板信息
    function set_msg($_W){
        $access_token = getaccess_token($_W);
        $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('zhvip_shoporder',array('id'=>$_POST['fh_id']));
        $store=pdo_get('zhvip_store',array('id'=>$order['store_id']));
        $user=pdo_get('zhvip_user',array('id'=>$order['user_id']));
       $formwork = [
                'touser' => $user["openid"],
                'template_id' => $res["tid4"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'character_string7' => [
                        'value' => $order['order_num'],
                        'color' => '#173177',
                    ],
                    'thing8' => [
                        'value' => $order['address'],
                        'color' => '#173177',
                    ],
                     'character_string3' => [
                        'value' => $order['kd_num'],
                        'color' => '#173177',
                    ],
                    'phrase2' => [
                        'value' => $order['kd_name'],
                        'color' => '#173177',
                    ],
                   
                ],
            ];
		$formwork = json_encode($formwork);
		$url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=".$access_token."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
        $data = curl_exec($ch);
        curl_close($ch);
     pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["tid4"]));
    }
    echo set_msg($_W);


        ////////模板消息//////
        message('发货成功！', $this->createWebUrl2('dlmallorderinfo',array('id'=>$_GPC['fh_id'])), 'success');
    }else{
        message('发货失败！','','error');
    }
}
if($_GPC['op']=='tg'){
        $id=$_GPC['id'];
        include_once IA_ROOT . '/addons/zh_vip/cert/WxPay.Api.php';
        load()->model('account');
        load()->func('communication');
        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();
       //$path_cert = IA_ROOT . '/addons/zh_vip/cert/apiclient_cert.pem';
       // $path_key = IA_ROOT . '/addons/zh_vip/cert/apiclient_key.pem';
        $path_cert = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
        $account_info = $_W['account'];
        $refund_order =pdo_get('zhvip_shoporder',array('id'=>$id));  
        $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $key=$res['wxkey'];
        $mchid=$res['mchid']; 
        //print_r( $refund_order );die;
        $out_trade_no=$refund_order['code'];//商户订单号
        $fee = $refund_order['money'] * 100;
            //$refundid = $refund_order['transid'];
            //$refundid='4200000022201710178579320894';
            $input->SetAppid($appid);
            $input->SetMch_id($mchid);
            $input->SetOp_user_id($mchid);
            $input->SetRefund_fee($fee);
            $input->SetTotal_fee($fee);
           // $input->SetTransaction_id($refundid);
            $input->SetOut_refund_no($refund_order['order_num']);
            $input->SetOut_trade_no($out_trade_no);
            $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);   
     //var_dump($result);die;
            if ($result['result_code'] == 'SUCCESS') {//退款成功
           pdo_update('zhvip_shoporder',array('state'=>7),array('id'=>$id));
           message('退款成功',$this->createWebUrl2('dlmallorderinfo',array()),'success');
         
    }else{
        message($result['err_code_des'],'','error');
}
}

if($_GPC['op']=='jj'){
    $res=pdo_update('zhvip_shoporder',array('state'=>8),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝退款成功',$this->createWebUrl2('dlmallorderinfo',array()),'success');
    }else{
       message('拒绝退款失败','','error');
    }
}
include $this->template('web/dlmallorderinfo');