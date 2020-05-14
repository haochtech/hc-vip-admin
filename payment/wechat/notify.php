<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../../../framework/bootstrap.inc.php';
global $_W, $_GPC;
$input = file_get_contents('php://input');
$isxml = true;
if (!empty($input) && empty($_GET['out_trade_no'])) {
	$obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$res = $data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => ''
		);
		echo array2xml($result);
		exit;
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => empty($data['return_msg']) ? $data['err_code_des'] : $data['return_msg']
		);
		echo array2xml($result);
		exit;
	}
	$get = $data;
} else {
	$isxml = false;
	$get = $_GET;
}
load()->web('common');
load()->model('mc');
load()->func('communication');
$_W['uniacid'] = $_W['weid'] = intval($get['attach']);

$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
$_W['acid'] = $_W['uniaccount']['acid'];
$paySetting = uni_setting($_W['uniacid'], array('payment'));
if($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS' ){
	$logno = trim($res['out_trade_no']);
	if (empty($logno)) {
		exit;
	}
$str=$_W['siteroot'];
	$n = 0;
for($i = 1;$i <= 3;$i++) {
    $n = strpos($str, '/', $n);
    $i != 3 && $n++;
}
$url=substr($str,0,$n);

	$order=pdo_get('zhvip_order',array('code'=>$logno));
	$store=pdo_get('zhvip_store',array('id'=>$order['store_id']));


	$czorder=pdo_get('zhvip_czorder',array('code'=>$logno));
	$czstore=pdo_get('zhvip_store',array('id'=>$czorder['store_id']));

	$timeorder=pdo_get('zhvip_timeorder',array('code'=>$logno));

	$shoporder=pdo_get('zhvip_shoporder',array('code'=>$logno));

	$numcard=pdo_get('zhvip_numcardorder',array('code'=>$logno));
	if($numcard['state']==1){
		$card=pdo_get('zhvip_numcard',array('id'=>$numcard['card_id']));
		$res=pdo_update('zhvip_numcardorder',array('state'=>2),array('id'=>$numcard['id']));
		if($res){
			$data3['user_id']=$numcard['user_id'];
			$data3['card_id']=$numcard['card_id'];
			$data3['money']=$numcard['money'];
			$data3['type']=$card['type'];
			$data3['number']=$card['number'];
			$data3['uniacid']=$numcard['uniacid'];
			$data3['lq_time']=date("Y-m-d H:i:s");
			pdo_insert('zhvip_mynumcard',$data3);
		}
		///////////加积分//////////////
         $system=pdo_get('zhvip_system',array('uniacid'=>$numcard['uniacid']));
         if($system['is_jf']==1){
         	 $jifen=round(($system['integral']/100)*$numcard['money']);
         	 pdo_update('zhvip_user',array('integral +='=>$jifen),array('id'=>$numcard['user_id']));
         	 $data5['score']=$jifen;
            $data5['user_id']=$numcard['user_id'];
            $data5['note']='购买次卡';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$numcard['uniacid'];//小程序id
            pdo_insert('zhvip_jfmx',$data5);
         }
         ///////////加积分//////////////
        pdo_update('zhvip_user',array('cumulative +='=>$numcard['money'],'level_cumulative +='=>$numcard['money']),array('id'=>$numcard['user_id']));
		$user=pdo_get('zhvip_user',array('id'=>$numcard['user_id']));
		$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
		$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
		if($level){
			$money=$user['level_cumulative'];
			for($i=0;$i<count($level);$i++){
				if(($money-$level[$i]['threshold'])>=0){
					$money=$money-$level[$i]['threshold'];
					pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$numcard['user_id'])); 
					file_get_contents("".$url."/app/index.php?i=".$user['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$numcard['user_id']."&level=".$level[$i]['id']);//模板消息
				}else{
				 break;
			 }
		 }
	 }


	}
	if($shoporder['state']==1){
		if($shoporder['is_zt']!=1){
			pdo_update('zhvip_shoporder',array('state'=>2,'pay_time'=>time()),array('id'=>$shoporder['id']));
		}else{
			pdo_update('zhvip_shoporder',array('state'=>3,'pay_time'=>time()),array('id'=>$shoporder['id']));
		}
		$good=pdo_getall('zhvip_ordergoods',array('order_id'=>$shoporder['id']));
		for($j=0;$j<count($good);$j++){
			pdo_update('zhvip_goods',array('sales +='=>$good[$j]['number'],'inventory -='=>$good[$j]['number']),array('id'=>$good[$j]['good_id']));
			//pdo_update('zhvip_spec_combination',array('number -='=>$good[$j]['number']),array('id'=>$good[$j]['combination_id']));
		}
		if($shoporder['coupons_id']){
			pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$shoporder['user_id'],'coupons_id'=>$shoporder['coupons_id']));
		}
		pdo_update('zhvip_user',array('cumulative +='=>$shoporder['money'],'level_cumulative +='=>$shoporder['money']),array('id'=>$shoporder['user_id']));
		$user=pdo_get('zhvip_user',array('id'=>$shoporder['user_id']));
		$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
		$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
		if($level){
			$money=$user['level_cumulative'];
			for($i=0;$i<count($level);$i++){
				if(($money-$level[$i]['threshold'])>=0){
					$money=$money-$level[$i]['threshold'];
					pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$shoporder['user_id'])); 
					file_get_contents("".$url."/app/index.php?i=".$user['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$shoporder['user_id']."&level=".$level[$i]['id']);//模板消息
				}else{
				 break;
			 }
		 }
	 }
	 file_get_contents("".$url."/app/index.php?i=".$shoporder['uniacid']."&c=entry&a=wxapp&do=Sms2&m=zh_vip&store_id=".$shoporder['store_id']);//短信
	 file_get_contents("".$url."/app/index.php?i=".$shoporder['uniacid']."&c=entry&a=wxapp&do=Print2&m=zh_vip&order_id=".$shoporder['id']);//短信

	}

	if($order['state']==1){
		$data2['state']=2;
		$data2['time']=date('Y-m-d H:i:s',time());
        $data2['order_num']=date('YmdHis',time()).rand(1111,9999);
		pdo_update('zhvip_order',$data2,array('id'=>$order['id']));
		if($order['coupons_id']){
            pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$order['user_id'],'coupons_id'=>$order['coupons_id']));
          }
          pdo_update('zhvip_user',array('cumulative +='=>$order['money'],'level_cumulative +='=>$order['money']),array('id'=>$order['user_id']));
          $user=pdo_get('zhvip_user',array('id'=>$order['user_id']));
          $dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
          $level=pdo_getall('zhvip_level',array('uniacid'=>$order['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
          if($level){
            $money=$user['level_cumulative'];
            for($i=0;$i<count($level);$i++){
              if(($money-$level[$i]['threshold'])>=0){
              	$money=$money-$level[$i]['threshold'];
                 pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$order['user_id'])); 
                 file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$order['user_id']."&level=".$level[$i]['id']);//模板消息
               }else{
               	 break;
               }
              
             }
           }
         
         file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=Message&m=zh_vip&openid=".$user['openid']."&money=".$order['money']."&store_name=".$store['name']."&form_id=".$order['form_id']);//改变订单状态
         file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=Print&m=zh_vip&order_id=".$order['id']);//打印
         ///////////加积分//////////////
         $system=pdo_get('zhvip_system',array('uniacid'=>$order['uniacid']));
         if($system['is_jf']==1){
         	 $jifen=round(($system['integral']/100)*$order['money']);
         	 pdo_update('zhvip_user',array('integral +='=>$jifen),array('id'=>$order['user_id']));
         	 $data5['score']=$jifen;
            $data5['user_id']=$order['user_id'];
            $data5['note']='门店买单';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$order['uniacid'];//小程序id
            pdo_insert('zhvip_jfmx',$data5);
         }
         ///////////加积分//////////////
        
	}
	if($czorder['state']==1){
		pdo_update('zhvip_czorder',array('state'=>2),array('id'=>$czorder['id']));
		file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Recharge&m=zh_vip&user_id=".$czorder['user_id']."&store_id=".$czorder['store_id']."&money=".$czorder['money']."&money2=".$czorder['money2']);//改变订单状态
		file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=CzPrint&m=zh_vip&order_id=".$czorder['id']);//打印
		///////////加积分//////////////
         $system=pdo_get('zhvip_system',array('uniacid'=>$czorder['uniacid']));
         if($system['is_jf']==1){
         	 $jifen=round(($system['integral']/100)*$czorder['money']);
         	 pdo_update('zhvip_user',array('integral +='=>$jifen),array('id'=>$czorder['user_id']));
         	 $data5['score']=$jifen;
            $data5['user_id']=$czorder['user_id'];
            $data5['note']='在线充值';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$czorder['uniacid'];//小程序id
            pdo_insert('zhvip_jfmx',$data5);
         }
         ///////////加积分//////////////
         

         if(!$czorder['store_id']){
         	$level=pdo_getall('zhvip_level',array('uniacid'=>$czorder['uniacid']),array(),'','level ASC',array(1,1));
			  $data2['grade']=$level['0']['id'];
			  $data2['code_time']=time(); 
			  $num="0000000".$czorder['user_id'];
			  $data2['vip_number'] =substr($num, -6);
			  $data2['vip_code'] =str_shuffle(date('Ymd').rand(1111,9999));
			  pdo_update('zhvip_user',$data2,array('id'=>$czorder['user_id']));
			  $user=pdo_get('zhvip_user',array('id'=>$czorder['user_id']));
			  file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Message2&m=zh_vip&openid=".$user['openid']."&code=".$data2['vip_code']."&level_name=".$level['name']."&name=".$user['name']."&tel=".$user['tel']."&form_id=".$czorder['form_id']);//开卡
			  file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Message3&m=zh_vip&openid=".$user['openid']."&code=".$user['vip_code']."&store_name=".$czstore['name']."&money=".$czorder['money']."&money2=".$czorder['money2']."&name=".$user['name']."&time=".$czorder['time']."&form_id=".$czorder['form_id']);//充值
			  file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Sms3&m=zh_vip&store_id=".$czorder['store_id']);//短信
         }else{
         	 $user=pdo_get('zhvip_user',array('id'=>$czorder['user_id']));
         	file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Message3&m=zh_vip&openid=".$user['openid']."&code=".$user['vip_code']."&store_name=".$czstore['name']."&money=".$czorder['money']."&money2=".$czorder['money2']."&name=".$user['name']."&time=".$czorder['time']."&form_id=".$czorder['form_id']);//充值
         	file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Sms3&m=zh_vip&store_id=".$czorder['store_id']);//短信

         }
         
	}


	if($timeorder['state']==1){
		pdo_update('zhvip_timeorder',array('state'=>2,'pay_time'=>date("Y-m-d H:i:s")),array('id'=>$timeorder['id']));
		$user=pdo_get('zhvip_user',array('id'=>$timeorder['user_id']));
		if($user['grade']>0){
			pdo_update('zhvip_user',array('vip_time'=>time()+60*60*24*$timeorder['day']),array('id'=>$timeorder['user_id']));
		}else{
			$level=pdo_getall('zhvip_level',array('uniacid'=>$timeorder['uniacid']),array(),'','level ASC',array(1,1));
			  $data2['grade']=$level['0']['id'];
			  $data2['code_time']=time(); 
			  $num="0000000".$timeorder['user_id'];
			  $data2['vip_number'] =substr($num, -6);
			  $data2['vip_code'] =str_shuffle(date('Ymd').rand(1111,9999));
			  $data2['vip_time']=time()+60*60*24*$timeorder['day'];
			  pdo_update('zhvip_user',$data2,array('id'=>$timeorder['user_id']));
			   $user=pdo_get('zhvip_user',array('id'=>$timeorder['user_id']));
			  file_get_contents("".$url."/app/index.php?i=".$timeorder['uniacid']."&c=entry&a=wxapp&do=Message2&m=zh_vip&openid=".$user['openid']."&code=".$data2['vip_code']."&level_name=".$level['name']."&name=".$user['name']."&tel=".$user['tel']."&form_id=".$timeorder['form_id']);//开卡
		}
	}





















			$result = array(
				'return_code' => 'SUCCESS',
				'return_msg' => 'OK'
			);
			echo array2xml($result);
			exit;
	
	}else{
		//订单已经处理过了
		$result = array(
			'return_code' => 'SUCCESS',
			'return_msg' => 'OK'
		);
		echo array2xml($result);
		exit;
	}
