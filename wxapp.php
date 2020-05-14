<?php

defined('IN_IA') or exit('Access Denied');

class Zh_vipModuleWxapp extends WeModuleWxapp {
	public function doPageSystem(){
		global $_W, $_GPC;
		$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
		echo json_encode($res);
	}
	//获取openid
	public function doPageOpenid(){
		global $_W, $_GPC;
		$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
		$code=$_GPC['code'];
		$appid=$res['appid'];
		$secret=$res['appsecret'];
	// echo $appid;die;
		$url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
		function httpRequest($url,$data = null){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			if (!empty($data)){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//执行
			$output = curl_exec($curl);
			curl_close($curl);
			return $output;
		}
		$res=httpRequest($url);
		print_r($res);
	}
		//登录用户信息
	public function doPageLogin(){
		global $_GPC, $_W;
		$openid=$_GPC['openid'];
		$res=pdo_get('zhvip_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
		if($res){
			$user_id=$res['id'];
			$data['openid']=$_GPC['openid'];
			if($_GPC['img']){
				$data['img']=$_GPC['img'];	
			}
			if($_GPC['name']){
				$data['nickname']=$_GPC['name'];
			}


			$res = pdo_update('zhvip_user', $data, array('id' =>$user_id));
			$sql="select a.*,b.name as level_name,b.img as level_img,b.details,b.discount,b.level as level_type,b.my_img from " . tablename("zhvip_user") . " a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade   WHERE a.openid=:openid and a.uniacid=:uniacid ";
			$list=pdo_fetch($sql,array(':openid'=>$_GPC['openid'],':uniacid'=>$_W['uniacid']));
			echo json_encode($list);
		}else{
			$data['openid']=$_GPC['openid'];
			$data['img']=$_GPC['img'];
			$data['nickname']=$_GPC['name'];
			$data['uniacid']=$_W['uniacid'];
			$data['time']=time();
			$res2=pdo_insert('zhvip_user',$data);

			$sql="select a.*,b.name as level_name,b.img as level_img,b.details,b.discount,b.level as level_type,b.my_img from " . tablename("zhvip_user") . " a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade   WHERE a.openid=:openid and a.uniacid=:uniacid ";
			$list=pdo_fetch($sql,array(':openid'=>$_GPC['openid'],':uniacid'=>$_W['uniacid']));
			echo json_encode($list);

		}
	}
//url(七牛)
	public function doPageUrl(){
		global $_GPC, $_W;
		echo $_W['attachurl'];
	}
	public function doPageUrl2(){
		global $_GPC, $_W;
		echo $_W['siteroot'];
	}
		//注册会员
	public function doPageAddVip(){
		global $_GPC, $_W;
		$res=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid']),array(),'','level ASC',array(1,1));
		$data['grade']=$res['0']['id'];
		$data['code_time']=time(); 
		$num="0000000".$_GPC['user_id'];
		$data['vip_number'] =substr($num, -6);
		$data['vip_code'] =str_shuffle(date('Ymd').rand(1111,9999));
		if($_GPC['day']>0){
			$time=time()+60*60*24*$_GPC['day'];
		$data['vip_time']=$time;//到期时间
	}
	$data['name']=$_GPC['name'];//姓名
	$data['tel']=$_GPC['tel'];//电话
	$data['birthday']=$_GPC['birthday'];//生日
	$data['type']=1;//虚拟卡
	$data['address']=$_GPC['address'];//地址
	$res=pdo_update('zhvip_user',$data,array('id'=>$_GPC['user_id']));
	if($res){
		$sql="select a.*,b.name as level_name,b.img as level_img,b.details,b.discount from " . tablename("zhvip_user") . " a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade   WHERE a.id=:user_id ";
		$list=pdo_fetch($sql,array(':user_id'=>$_GPC['user_id']));
		echo json_encode($list);
	}else{
		echo '2';
	}
}
		//绑定实体卡
public function doPageAddVip2(){
	global $_GPC, $_W;
	$stk=pdo_get('zhvip_stinfo',array('code'=>$_GPC['code'],'pwd'=>$_GPC['pwd']));
	$user=pdo_get('zhvip_user',array('vip_code'=>$_GPC['code']));
	if($stk and !$user){
        $res=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid']),array(),'','level ASC',array(1,1));
        $data['grade']=$res['0']['id'];
		$data['code_time']=time(); 
		$num="0000000".$_GPC['user_id'];
		$data['vip_number'] =substr($num, -6);
		$data['vip_code'] =$_GPC['code'];
		if($stk['term']>0){
			$time=time()+60*60*24*$stk['term'];
			$data['vip_time']=$time;//到期时间
		}
		$data['type']=2;//实体卡
	$data['name']=$_GPC['name'];//姓名
	$data['tel']=$_GPC['tel'];//电话
	$data['birthday']=$_GPC['birthday'];//生日
	$data['address']=$_GPC['address'];//地址
	$res=pdo_update('zhvip_user',$data,array('id'=>$_GPC['user_id']));
	if($res){
		pdo_update('zhvip_stinfo',array('state'=>1),array('code'=>$_GPC['code'],'pwd'=>$_GPC['pwd']));
		$sql="select a.*,b.name as level_name,b.img as level_img,b.details,b.discount from " . tablename("zhvip_user") . " a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade   WHERE a.id=:user_id ";
		$list=pdo_fetch($sql,array(':user_id'=>$_GPC['user_id']));
		echo json_encode($list);
	}else{
		echo '卡号卡密不匹配或已绑定!';
	}
}else{
	echo '卡号卡密不匹配或已绑定!';
}


}

public function doPageAddTimeOrder(){
	global $_W, $_GPC;
	$data['user_id']=$_GPC['user_id'];
	$data['form_id']=$_GPC['form_id'];
	$data['money']=$_GPC['money'];
	$data['day']=$_GPC['day'];
	$data['state']=1;
	$data['time']=date('Y-m-d H:i:s');
	$data['uniacid']=$_W['uniacid'];
	$res=pdo_insert('zhvip_timeorder',$data);
	$order_id=pdo_insertid();
	if($res){
		if($_GPC['name']){
			$data2['name']=$_GPC['name'];//姓名
			$data2['tel']=$_GPC['tel'];//电话
			$data2['birthday']=$_GPC['birthday'];//生日
			$data2['address']=$_GPC['address'];//地址
			pdo_update('zhvip_user',$data2,array('id'=>$_GPC['user_id']));
		}	
		echo $order_id;
	}else{
		echo  '下单失败';
	}
}

//续费
public function doPageUpdTimeOrder(){
	global $_W, $_GPC;
	if($_GPC['money']==0){
		pdo_update('zhvip_user',array('vip_time'=>time()+60*60*24*$_GPC['day']),array('id'=>$_GPC['user_id']));
	}else{
		$data['user_id']=$_GPC['user_id'];
		$data['form_id']=$_GPC['form_id'];
		$data['money']=$_GPC['money'];
		$data['day']=$_GPC['day'];
		$data['state']=1;
		$data['time']=date('Y-m-d H:i:s');
		$data['uniacid']=$_W['uniacid'];
		$res=pdo_insert('zhvip_timeorder',$data);
		$order_id=pdo_insertid();
		if($res){
			echo $order_id;
		}else{
			echo  '下单失败';
		}
	}
	
}
//修改会员信息
public function doPageUpdUser(){
	global $_GPC, $_W;
			$data['name']=$_GPC['name'];//姓名
			$data['tel']=$_GPC['tel'];//电话
			$data['birthday']=$_GPC['birthday'];//生日
			$data['address']=$_GPC['address'];//地址
			$data['email']=$_GPC['email'];//邮箱
			$data['education']=$_GPC['education'];//学历
			$data['industry']=$_GPC['industry'];//行业
			$data['hobby']=$_GPC['hobby'];//爱好
			$res=pdo_update('zhvip_user',$data,array('id'=>$_GPC['user_id']));
			if($res){
				echo '1';
			}else{
				echo '2';
			}
		}
//用户信息
		public function doPageUserInfo(){
			global $_GPC, $_W;
			$sql="select a.*,b.name as level_name,b.img as level_img,b.details,b.discount,b.level as level_type,b.my_img from " . tablename("zhvip_user") . " a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade   WHERE a.id=:user_id ";
			$list=pdo_fetch($sql,array(':user_id'=>$_GPC['user_id']));
			echo json_encode($list);
		}
//解密
		public function doPageJiemi(){
			global $_W, $_GPC;
			$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
			include_once  IA_ROOT . "/addons/zh_vip/wxBizDataCrypt.php";
			$appid = $res['appid'];
			$sessionKey = $_GPC['sessionKey'];
			$encryptedData=$_GPC['data'];
			$iv = $_GPC['iv'];
			$pc = new WXBizDataCrypt($appid, $sessionKey);
			$errCode = $pc->decryptData($encryptedData, $iv, $data );
			if ($errCode == 0) {
				//echo json_encode($data);
				print($data . "\n");
			} else {
				print($errCode . "\n");
			}
		}
//下订单
public function doPageAddOrder(){
	global $_W, $_GPC;
if($_GPC['pay_type']==2){//余额支付
	$data2['money']=$_GPC['money'];
	$data2['user_id']=$_GPC['user_id'];
	$data2['store_id']=$_GPC['store_id'];
	$data2['type']=2;
	$data2['note']='门店消费';
	$data2['time']=date('Y-m-d H:i:s');
	$data2['uniacid']=$_W['uniacid'];//小程序id
	$res2=pdo_insert('zhvip_qbmx',$data2);
	$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
	if($res2){
		pdo_update('zhvip_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));//减余额
		$data['user_id']=$_GPC['user_id'];//用户id
		$data['store_id']=$_GPC['store_id'];//商家id
		$data['price']=$_GPC['price'];//总价
		$data['money']=$_GPC['money'];//实付
		$data['pay_type']=$_GPC['pay_type'];//类型1.微信2.余额
		$data['preferential']=$_GPC['preferential'];//折扣
		$data['preferential2']=$_GPC['preferential2'];//优惠券
		$data['coupons_id']=$_GPC['coupons_id'];//优惠券id
		$data['time']=date('Y-m-d H:i:s',time());
		$data['order_num']=date('YmdHis',time()).rand(1111,9999);
		$data['uniacid']=$_W['uniacid'];
		$data['state']=2;
		$res=pdo_insert('zhvip_order',$data);
		$order_id=pdo_insertid();
		if($res){
			if($_GPC['coupons_id']){
				pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
			}
			pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
			$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
			$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
			$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
			if($level){
				$money=$user['level_cumulative'];
				for($i=0;$i<count($level);$i++){
					if(($money-$level[$i]['threshold'])>=0){
						$money=$money-$level[$i]['threshold'];
						pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id'])); 
						file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
					}else{
						break;
					}
				}
			}
			echo $order_id;
		}else{
			echo '下单失败';
		}
	}
	}elseif($_GPC['pay_type']==1){//微信支付
		$data['user_id']=$_GPC['user_id'];
		$data['store_id']=$_GPC['store_id'];
		$data['price']=$_GPC['price'];
		$data['money']=$_GPC['money'];
		$data['pay_type']=$_GPC['pay_type'];//类型1.微信2.余额
		$data['coupons_id']=$_GPC['coupons_id'];
		$data['preferential']=$_GPC['preferential'];
		$data['preferential2']=$_GPC['preferential2'];//优惠券
		$data['uniacid']=$_W['uniacid'];
		$data['state']=1;
		$data['form_id']=$_GPC['form_id'];
		$res=pdo_insert('zhvip_order',$data);
		$order_id=pdo_insertid();
		if($res){
			echo $order_id;
		}else{
			echo '下单失败';
		}
}elseif($_GPC['pay_type']==3){//积分支付
	$data2['score']=$_GPC['jf'];
	$data2['user_id']=$_GPC['user_id'];
	$data2['note']='门店买单';
	$data2['type']=2;
	$data2['cerated_time']=date('Y-m-d H:i:s');
	$data2['uniacid']=$_W['uniacid'];//小程序id
	$res2=pdo_insert('zhvip_jfmx',$data2);
	if($res2){
		pdo_update('zhvip_user',array('integral -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));//减余额
		$data['user_id']=$_GPC['user_id'];//用户id
		$data['store_id']=$_GPC['store_id'];//商家id
		$data['price']=$_GPC['price'];//总价
		$data['money']=$_GPC['money'];//实付
		$data['pay_type']=$_GPC['pay_type'];//类型1.微信2.余额
		$data['preferential']=$_GPC['preferential'];//折扣
		$data['preferential2']=$_GPC['preferential2'];//优惠券
		$data['coupons_id']=$_GPC['coupons_id'];//优惠券id
		$data['time']=date('Y-m-d H:i:s',time());
		$data['order_num']=date('YmdHis',time()).rand(1111,9999);
		$data['uniacid']=$_W['uniacid'];
		$data['state']=2;
		$res=pdo_insert('zhvip_order',$data);
		$order_id=pdo_insertid();
		if($res){
			if($_GPC['coupons_id']){
				pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
			}
			pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
			$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
			$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
			$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
			if($level){
				$money=$user['level_cumulative'];
				for($i=0;$i<count($level);$i++){
					if(($money-$level[$i]['threshold'])>=0){
						$money=$money-$level[$i]['threshold'];
						pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id']));
						file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息 
					}else{
						break;
					}
				}
			}
			echo $order_id;
		}else{
			echo '下单失败';
		}
	}
}

}


//查看我的订单
public function doPageMyOrder(){
	global $_W, $_GPC;
	$where=" WHERE a.user_id=:user_id and a.state=2";
	if($_GPC['time']){
		$where .=" and a.time LIKE  concat('%', :time,'%')";
		$data[':time']=$_GPC['time'];      
	}
	$data[':user_id']=$_GPC['user_id'];
	$sql="select a.*,b.name as store_name,b.md_img as store_logo from " . tablename("zhvip_order") . " a"  . " left join " . tablename("zhvip_store") . " b on b.id=a.store_id".$where." order by id DESC";
	$list=pdo_fetchall($sql,$data);
	echo json_encode($list);
}
	//查看订单详情
public function doPageMyOrderInfo(){
	global $_W, $_GPC;
	$sql="select a.*,b.name as store_name,b.md_img as store_logo from " . tablename("zhvip_order") . " a"  . " left join " . tablename("zhvip_store") . " b on b.id=a.store_id   WHERE a.id=:id ";
	$list=pdo_fetch($sql,array(':id'=>$_GPC['order_id']));
	echo json_encode($list);
}

//支付
public function doPagePay(){
global $_W, $_GPC;
include IA_ROOT.'/addons/zh_vip/wxpay.php';
	 // include 'wxpay.php';
$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
$appid=$res['appid'];
	$openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
	$mch_id=$res['mchid'];
	$key=$res['wxkey'];
	$user=pdo_get('zhvip_user',array('openid'=>$_GPC['openid']));
    $out_trade_no =time().$user['id'];
	$root=$_W['siteroot'];
	pdo_update('zhvip_order',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
	$total_fee =$_GPC['money'];
		if(empty($total_fee)) //押金
		{
			$body = "订单付款";
			$total_fee = floatval(99*100);
		}else{
			$body = "订单付款";
			$total_fee = floatval($total_fee*100);
		}
		$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
		$return=$weixinpay->pay();
		echo json_encode($return);
}
//支付
public function doPagePay2(){
	global $_W, $_GPC;
	include IA_ROOT.'/addons/zh_vip/wxpay.php';
 // include 'wxpay.php';
	$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	$appid=$res['appid'];
	$openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
	$mch_id=$res['mchid'];
	$key=$res['wxkey'];
	$user=pdo_get('zhvip_user',array('openid'=>$_GPC['openid']));
    $out_trade_no =time().$user['id'];
	$root=$_W['siteroot'];
	pdo_update('zhvip_czorder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
	$total_fee =$_GPC['money'];
	if(empty($total_fee)) //押金
	{
		$body = "订单付款";
		$total_fee = floatval(99*100);
	}else{
		$body = "订单付款";
		$total_fee = floatval($total_fee*100);
	}
	$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
	$return=$weixinpay->pay();
	echo json_encode($return);
}
//支付
public function doPagePay3(){
	global $_W, $_GPC;
	include IA_ROOT.'/addons/zh_vip/wxpay.php';
 // include 'wxpay.php';
	$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	$appid=$res['appid'];
	$openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
	$mch_id=$res['mchid'];
	$key=$res['wxkey'];
	$user=pdo_get('zhvip_user',array('openid'=>$_GPC['openid']));
    $out_trade_no =time().$user['id'];
	$root=$_W['siteroot'];
	pdo_update('zhvip_shoporder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
	$total_fee =$_GPC['money'];
	if(empty($total_fee)) //押金
	{
		$body = "订单付款";
		$total_fee = floatval(99*100);
	}else{
		$body = "订单付款";
		$total_fee = floatval($total_fee*100);
	}
	$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
	$return=$weixinpay->pay();
	echo json_encode($return);
}
	 //支付
public function doPagePay4(){
	global $_W, $_GPC;
	include IA_ROOT.'/addons/zh_vip/wxpay.php';
 // include 'wxpay.php';
	$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	$appid=$res['appid'];
	$openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
	$mch_id=$res['mchid'];
	$key=$res['wxkey'];
	$user=pdo_get('zhvip_user',array('openid'=>$_GPC['openid']));
    $out_trade_no =time().$user['id'];
	$root=$_W['siteroot'];
	pdo_update('zhvip_timeorder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
	$total_fee =$_GPC['money'];
	if(empty($total_fee)) //押金
	{
		$body = "订单付款";
		$total_fee = floatval(99*100);
	}else{
		$body = "订单付款";
		$total_fee = floatval($total_fee*100);
	}
	$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
	$return=$weixinpay->pay();
	echo json_encode($return);
}

//支付
public function doPagePay5(){
	global $_W, $_GPC;
	include IA_ROOT.'/addons/zh_vip/wxpay.php';
 // include 'wxpay.php';
	$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	$appid=$res['appid'];
	$openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
	$mch_id=$res['mchid'];
	$key=$res['wxkey'];
	$user=pdo_get('zhvip_user',array('openid'=>$_GPC['openid']));
    $out_trade_no =time().$user['id'];
	$root=$_W['siteroot'];
	pdo_update('zhvip_numcardorder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
	$total_fee =$_GPC['money'];
	if(empty($total_fee)) //押金
	{
		$body = "订单付款";
		$total_fee = floatval(99*100);
	}else{
		$body = "订单付款";
		$total_fee = floatval($total_fee*100);
	}
	$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
	$return=$weixinpay->pay();
	echo json_encode($return);
}


//短信验证码
public function doPageSms(){
	global $_W, $_GPC;
	$res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	$tpl_id=$res['tpl_id'];
	$tel=$_GPC['tel'];
	$code=$_GPC['code'];
	$key=$res['appkey'];
	$url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D".$code."&key=".$key;
	$data=file_get_contents($url);
	print_r($data);
}
	//默认门店
public function doPageStore(){
	global $_W, $_GPC;
	$lat=$_GPC['lat'];
	$lng=$_GPC['lng'];
	$system=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
	if($system['md_xs']==1){
		$res=pdo_get('zhvip_store',array('is_default'=>1,'uniacid'=>$_W['uniacid']));
		if($res){
			echo json_encode($res);
		}else{
			$res=pdo_get('zhvip_store',array('uniacid'=>$_W['uniacid']),array(),'','num ASC');
			echo json_encode($res);
		}
	}else{
		$sql="SELECT *, ROUND(6378.138*2*ASIN(SQRT(POW(SIN(($lat*3.1415926/180-SUBSTRING_INDEX(coordinates, ',', 1)*3.1415926/180)/2),2)+COS($lat*3.1415926/180)*COS(SUBSTRING_INDEX(coordinates, ',', 1)*3.1415926/180)*POW(SIN(($lng*3.1415926/180-SUBSTRING_INDEX(coordinates, ',', -1)*3.1415926/180)/2),2)))*1000) AS juli  FROM ".tablename("zhvip_store") ." where uniacid=".$_W['uniacid']." ORDER BY juli ASC";
		$res=pdo_fetch($sql);
		echo json_encode($res);
	}	
}
	//门店列表
public function doPageStoreList(){
	global $_W, $_GPC;
	$where=" WHERE uniacid=:uniacid";
	if($_GPC['name']){
		$where .=" and name LIKE  concat('%', :name,'%')";
		$data[':name']=$_GPC['name'];      
	}
	$data[':uniacid']=$_W['uniacid'];

	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=$_GPC['pagesize'];
	$sql="select * from " . tablename("zhvip_store") . "".$where." order by num asc";
//    $sql=pdo_getall('zhvip_store',array('uniacid'=>$_W['uniacid']),array(),'','num ASC');
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);
	echo json_encode($list);
}
	//门店列表
public function doPageStoreList2(){
	global $_W, $_GPC;
	$where=" WHERE uniacid=:uniacid";
	$data[':uniacid']=$_W['uniacid'];
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=$_GPC['pagesize'];
	$sql="select *  from " . tablename("zhvip_store") . "".$where." order by sentiment DESC";
// $sql=pdo_getall('zhvip_store',array('uniacid'=>$_W['uniacid']),array(),'','sentiment DESC');
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);
	echo json_encode($list);
}
	//查看门店详情4678
public function doPageStoreInfo(){
	global $_W, $_GPC;
	pdo_update('zhvip_store',array('sentiment +='=>1),array('id'=>$_GPC['id']));
	$list=pdo_get('zhvip_store',array('id'=>$_GPC['id']));

	echo json_encode($list);
}
	//优惠券列表
public function doPageCoupons(){
	global $_W, $_GPC;
	$sql="select a.* ,b.name as Coupons_name,b.start_time,b.end_time,b.full,b.reduction,b.type,b.details,c.name as store_name,c.id as store_id,d.name as level_name from " . tablename("zhvip_usercoupons") . " a"  . " left join " . tablename("zhvip_coupons") . " b on b.id=a.coupons_id " . " left join " . tablename("zhvip_store") . " c on c.id=b.store_id " . " left join " . tablename("zhvip_level") . " d on d.level=b.level_type WHERE a.user_id=:user_id ";
	$list=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));

	$sql2 = "select a.*,b.name as level_name from " . tablename("zhvip_coupons") . " a"  . " left join " . tablename("zhvip_level") . " b on b.level=a.level_type WHERE a.uniacid=".$_W['uniacid']." and b.uniacid=".$_W['uniacid']." and  a.store_id in (0,".$_GPC['store_id'].") and UNIX_TIMESTAMP(a.end_time) >".time();
	$res=pdo_fetchall($sql2);
	$data['ok']=$list;
	$data['all']=$res;
	echo json_encode($data);
}
	//我的优惠券列表
public function doPageMyCoupons(){
	global $_W, $_GPC;
	$sql="select a.* ,b.name as Coupons_name,b.start_time,b.end_time,b.full,b.reduction,b.type,b.details,c.name as store_name,c.logo as store_logo,c.id as store_id,d.link_logo from " . tablename("zhvip_usercoupons") . " a"  . " left join " . tablename("zhvip_coupons") . " b on b.id=a.coupons_id " . " left join " . tablename("zhvip_store") . " c on c.id=b.store_id " . " left join " . tablename("zhvip_system") . " d on d.uniacid=b.uniacid WHERE a.user_id=:user_id and d.uniacid=:uniacid";
	$list=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id'],':uniacid'=>$_W['uniacid']));
	echo json_encode($list);
}
//我的优惠券列表
public function doPageMyCoupons2(){
	global $_W, $_GPC;
	$sql="select a.* ,b.name as Coupons_name,b.start_time,b.end_time,b.full,b.reduction,b.type,b.details,c.name as store_name,c.logo as store_logo,c.id as store_id,d.link_logo from " . tablename("zhvip_usercoupons") . " a"  . " left join " . tablename("zhvip_coupons") . " b on b.id=a.coupons_id " . " left join " . tablename("zhvip_store") . " c on c.id=b.store_id " . " left join " . tablename("zhvip_system") . " d on d.uniacid=b.uniacid WHERE a.user_id=:user_id and d.uniacid=:uniacid and (b.store_id=:store_id || b.store_id='')";
	$list=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id'],':uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']));
	echo json_encode($list);
}
//删除优惠券
public function doPageDelCoupons(){
	global $_W, $_GPC;
	$res=pdo_delete('zhvip_usercoupons',array('id'=>$_GPC['id']));
	if($res){
		echo  '1';
	}else{
		echo  '2';
	}
}
//删除过期的卡券
public function doPageDelAllCoupons(){
	global $_W, $_GPC;
	$time=time();
	$sql="select * from ".tablename('zhvip_coupons')."where UNIX_TIMESTAMP(end_time) <". $time;
	$list=pdo_fetchall($sql);
	for($i=0;$i<count($list);$i++){
		pdo_delete('zhvip_usercoupons',array('coupons_id'=>$list[$i]['id']));
	}
	if($sql){
		echo '1';
	}else{
		echo '2';
	}
}
//领取优惠券
public function doPageAddCoupons(){
	global $_W, $_GPC;
	$data['user_id']=$_GPC['user_id'];
	$data['coupons_id']=$_GPC['coupons_id'];
	$data['state']=2;
	$data['time']=date('Y-m-d H:i:s');
	$res=pdo_insert('zhvip_usercoupons',$data);
	if($res){
		echo '1';
	}else{
		echo '2';
	}
}
 //轮播图
public function  doPageAd(){
	global $_W, $_GPC;
	$list=pdo_getall('zhvip_ad',array('uniacid'=>$_W['uniacid'],'status'=>1),array(),'','orderby asc');
	echo json_encode($list);
}
//充值
public function doPageRecharge(){
	global $_W, $_GPC;
	$data['user_id']=$_GPC['user_id'];
	$data['money']=$_GPC['money'];
	$data['store_id']=$_GPC['store_id'];
	$data['type']=1;
	$data['note']='在线充值';
	$data['uniacid']=$_W['uniacid'];
	$data['time']=date('Y-m-d H:i:s');
	$res=pdo_insert('zhvip_qbmx',$data);
		$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
	if($_GPC['money2']!=0.00){
		$data2['user_id']=$_GPC['user_id'];
		$data2['money']=$_GPC['money2'];
		$data2['store_id']=$_GPC['store_id'];
		$data2['type']=1;
		$data2['note']='充值赠送';
		$data2['uniacid']=$_W['uniacid'];
		$data2['time']=date('Y-m-d H:i:s');
		$res2=pdo_insert('zhvip_qbmx',$data2);
			$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
	}
	if($res){
		$money=$_GPC['money']+$_GPC['money2'];
		pdo_update('zhvip_user',array('wallet +='=>$money),array('id'=>$_GPC['user_id']));
		echo '1';
	}else{
		echo '2';
	}
}
		//下充值订单
public function doPageAddCzOrder(){
	global $_W, $_GPC;
	$data['user_id']=$_GPC['user_id'];
	$data['store_id']=$_GPC['store_id'];
	$data['form_id']=$_GPC['form_id'];
	$data['money']=$_GPC['money'];
	$data['money2']=$_GPC['money2'];
	$data['state']=1;
	$data['time']=date('Y-m-d H:i:s');
	$data['uniacid']=$_W['uniacid'];
	$res=pdo_insert('zhvip_czorder',$data);
	$order_id=pdo_insertid();
	if($res){
		if($_GPC['name']){
	$data2['name']=$_GPC['name'];//姓名
	$data2['tel']=$_GPC['tel'];//电话
	$data2['birthday']=$_GPC['birthday'];//生日
	$data2['address']=$_GPC['address'];//地址
	pdo_update('zhvip_user',$data2,array('id'=>$_GPC['user_id']));
}

echo $order_id;
}else{
echo  '下单失败';
}
}
//我的充值记录
public function doPageRechargeList(){
	global $_W, $_GPC;
	$where=" WHERE user_id=:user_id";
	if($_GPC['time']){
		$where .=" and time LIKE  concat('%', :time,'%')";
		$data[':time']=$_GPC['time'];      
	}
	$data[':user_id']=$_GPC['user_id'];
	$sql="select * from " . tablename("zhvip_qbmx") . " ".$where." order by id DESC";
	$list=pdo_fetchall($sql,$data);
	echo json_encode($list);
}

//消费发送模板消息
public function doPageMessage(){
	global $_W, $_GPC;
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
		$formwork = [
                'touser' => $_GET["openid"],
                'template_id' => $res["tid"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'thing4' => [
                        'value' => $_GET['store_name'],
                        'color' => '#173177',
                    ],
                    'amount2' => [
                        'value' => $_GET['money'],
                        'color' => '#173177',
                    ],
                     'thing5' => [
                        'value' => date('Y-m-d H:i:s'),
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
		$user=pdo_get('zhvip_user',array('openid'=>$_GET["openid"]));
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["tid"]));
		return $data;
	}
	echo set_msg($_W);
}
//开卡发送模板消息
public function doPageMessage2(){
	global $_W, $_GPC;
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
		$formwork = [
                'touser' => $_GET["openid"],
                'template_id' => $res["tid2"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'number5' => [
                        'value' => $_GET['code'],
                        'color' => '#173177',
                    ],
                    'phrase1' => [
                        'value' => $_GET['level_name'],
                        'color' => '#173177',
                    ],
                     'name4' => [
                        'value' => $_GET['name'],
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
		$user=pdo_get('zhvip_user',array('openid'=>$_GET["openid"]));
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["tid2"]));
		return $data;
	}
	echo set_msg($_W);
}

//充值发送模板消息
public function doPageMessage3(){
	global $_W, $_GPC;
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
		$formwork = [
                'touser' => $user["openid"],
                'template_id' => $res["tid3"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'name1' => [
                        'value' => $_GET['name'],
                        'color' => '#173177',
                    ],
                    'amount3' => [
                        'value' => $_GET['money'],
                        'color' => '#173177',
                    ],
                     'time2' => [
                        'value' => $_GET['time'],
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
		$user=pdo_get('zhvip_user',array('openid'=>$_GET["openid"]));
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["tid3"]));
		return $data;
	}
	echo set_msg($_W);
}

//充值活动
public function doPageCzhd(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_czhd',array('uniacid'=>$_W['uniacid']),array(),'','full DESC');
	echo json_encode($res);
}
//升级进度
public function doPageUpgrade(){
	global $_W, $_GPC;
	$list=pdo_get('zhvip_level',array('id'=>$_GPC['level']));
	$res=pdo_get('zhvip_level',array('level >'=>$list['level'],'uniacid'=>$_W['uniacid']),array(),'','level asc');
	echo json_encode($res);
}
//等级列表
public function doPageLevel(){
	global $_W, $_GPC;
	$list=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid']));
	echo json_encode($list);
}
//帮助中心
public function doPageGetHelp(){
	global $_W, $_GPC;
	$res= pdo_getall('zhvip_help',array('uniacid'=>$_W['uniacid']),array() , '' , 'sort ASC');
	echo json_encode($res);
}

//商家登录
public function doPageStoreLogin(){
	global $_GPC, $_W;
	load()->model('user');
	$member = array();
	$member['username'] =$_GPC['user'];
	$member['password'] = $_GPC['password'];
	$record = user_single($member);
	if(!empty($record)) {
		$account = pdo_fetch("SELECT * FROM " . tablename("zhvip_admin") . " WHERE status=2 AND uid=:uid ORDER BY id DESC LIMIT 1", array(':uid' => $record['uid']));
		if (!empty($account)) {
		echo json_encode($account);
		} else {
			echo '您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！';
		}
	}else{
		echo '账号或密码错误';
	}
}
//统计
public function doPageStatistical(){
		global $_W, $_GPC;
		$time=date("Y-m-d");
		$time="'%$time%'";
		$storeid=$_GPC['store_id'];
		$xf = "select sum(money) as total from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2";
		$xf = pdo_fetch($xf);//今天的消费销售额
		$xfnum = "select * from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2";
		$xfnum = pdo_fetchall($xfnum);//今天的消费单数

		$cz = "select sum(money) as total from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2";
		$cz = pdo_fetch($cz);//今天的充值销售额
		$cznum = "select * from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2";
		$cznum = pdo_fetchall($cznum);//今天的充值单数

		//会员总数
		$totalhy=pdo_get('zhvip_user', array('uniacid'=>$_W['uniacid'],'grade !='=>0), array('count(id) as count'));
		//今日新增会员
		$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time2 from ".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time2 like ".$time;
		$jr=count(pdo_fetchall($sql));
		$data['xf']=$xf['total'];
		$data['xfnum']=count($xfnum);
		$data['cz']=$cz['total'];
		$data['cznum']=count($cznum);
		$data['hy']=$totalhy['count'];
		$data['jrhy']=$jr;
		echo json_encode($data);
	}
//消费记录
	public function doPageConsumption(){
		global $_W, $_GPC;
		$sql="select a.*,b.nickname,b.img from " . tablename("zhvip_order") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id   WHERE a.store_id=:store_id and a.state=2 order by id DESC";
		$list=pdo_fetchall($sql,array(':store_id'=>$_GPC['store_id']));
		echo json_encode($list);
	}
//会员列表
	public function doPageStoreUser(){
		global $_W, $_GPC;
		$keywords=$_GPC['keywords'];
		$keywords="'%$keywords%'";
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize=10;
		$user = "select * from " . tablename("zhvip_user")." WHERE (name LIKE ".$keywords." || tel LIKE ".$keywords." || vip_code LIKE ".$keywords." || vip_number LIKE ".$keywords.") and grade !=0 and uniacid=".$_W['uniacid'];
		$select_sql =$user." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
		$list = pdo_fetchall($select_sql,$data);
		for($i=0;$i<count($list);$i++){
			$order=pdo_getall('zhvip_order',array('user_id'=>$list[$i]['id'],'state'=>2));
			$order=count($order);
			$list[$i]['ordernum']=$order;
		}
		echo json_encode($list);
	}
//充值
	public function doPageStoreRecharge(){
		global $_W, $_GPC;
		$data['user_id']=$_GPC['user_id'];
		$data['store_id']=$_GPC['store_id'];
		$data['account_id']=$_GPC['account_id'];
		$data['note']=$_GPC['note'];
		$data['pay_type']=$_GPC['type'];
		$data['money']=$_GPC['money'];
		$data['state']=2;
		$data['time']=date('Y-m-d H:i:s');
		$data['uniacid']=$_W['uniacid'];
		$res=pdo_insert('zhvip_czorder',$data);
		$order=pdo_insertid();
		if($res){
			$data2['user_id']=$_GPC['user_id'];
			$data2['money']=$_GPC['money'];
			$data2['store_id']=$_GPC['store_id'];
			$data2['type']=1;
			$data2['note']='后台充值';
			$data2['uniacid']=$_W['uniacid'];
			$data2['time']=date('Y-m-d H:i:s');
			$res2=pdo_insert('zhvip_qbmx',$data2);
				$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
			if($res2){
				pdo_update('zhvip_user',array('wallet +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
				echo $order;
			}else{
				echo '下单失败!';
			}
		}
	}



//收银
	public function doPageCashier(){
		global $_W, $_GPC;
		if($_GPC['pay_type2']=='会员卡扣款'){
			$data2['money']=$_GPC['money'];
			$data2['user_id']=$_GPC['user_id'];
			$data2['store_id']=$_GPC['store_id'];
			$data2['type']=2;
			$data2['note']='门店收银';
			$data2['time']=date('Y-m-d H:i:s');
			 $data2['uniacid']=$_W['uniacid'];//小程序id
			 $res2=pdo_insert('zhvip_qbmx',$data2);
			 	$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
				pdo_update('zhvip_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));//减余额
			}
						$data['user_id']=$_GPC['user_id'];//用户id
						$data['store_id']=$_GPC['store_id'];//商家id
						$data['money']=$_GPC['money'];//实付
						$data['note']=$_GPC['note'];//实付
						$data['pay_type2']=$_GPC['pay_type2'];
						$data['account_id']=$_GPC['account_id'];
						$data['time']=date('Y-m-d H:i:s',time());
						$data['order_num']=date('YmdHis',time()).rand(1111,9999);
						$data['uniacid']=$_W['uniacid'];
						$data['state']=2;
						$res=pdo_insert('zhvip_order',$data);
						$order_id=pdo_insertid();
						if($res){
							pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
							$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
							$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
							$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
							if($level){
								$money=$user['level_cumulative'];
								for($i=0;$i<count($level);$i++){
									if(($money-$level[$i]['threshold'])>=0){
										$money=$money-$level[$i]['threshold'];
										pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id'])); 
										file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
									}else{
										break;
									}
								}
							}
							echo '1';
						}else{
							echo '2';
						}
					}


public function doPagePrint2(){ // $times打印次数
	global $_W, $_GPC;
	$res=pdo_get('zhvip_shoporder',array('id'=>$_GPC['order_id']));
	$res3=pdo_get('zhvip_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1));
	$store=pdo_get('zhvip_store',array('id'=>$res['store_id']));
	$res2 = pdo_getall('zhvip_ordergoods', array('order_id' => $_GPC['order_id']));
	if($res['is_zt']==1){
		$zt='到店自提';
	}else{
		$zt='快递配送';
	}
	if($res['pay_type']==1){
		$pay_type="微信支付";
	}elseif($res['pay_type']==2){
		$pay_type="余额支付";
	}elseif($res['pay_type']==3){
		$pay_type="积分支付";
	}
	$content = "\n\n\n\n";
	$content .= "         订单编号  #".$res['id']." \n\n";
	$content .= "          ".$res3['dyj_title']."\n\n";
	$content .= "------------".$pay_type."------------\n";
	$content .= "------------".$zt."------------\n";
	$content .= "------------".$store['name']."------------\n";
	$content .= "--------------------------------\n";

	$content .= '名称' . str_repeat(" ", 15) . "数量  价格";
    $content .= "--------------------------------";
    $name = '';
    for ($i = 0; $i < count($res2); $i++) {
        $name = $res2[$i]['name'];
        if ($res2[$i]['spec']) {
            $name = $res2[$i]['name'] . '(' . $res2[$i]['spec'] . ')';
        }
        $content .= "" . $name . " \n";
        $content .= str_repeat(" ", 20) . $res2[$i]['number'] . "   " . number_format($res2[$i]['number'] * $res2[$i]['money'], 2)." \n";
    }
    $content .= "--------------------------------";
	if($res['preferential']>0){
		$content .= "折扣：　　　　　　　　 -".$res['preferential']."\n";
		$content .= "--------------------------------\n";
	}
	if($res['preferential2']>0){
		$content .= "优惠：　　　　　　　　 -".$res['preferential2']."\n";
		$content .= "--------------------------------\n";	
	}
	$content .= "已付：　　　　　　　　　".$res['money']."\n";
	$content .= "--------------------------------\n";
	$content .= "联系人：".$res['user_name']."\n";
	$content .= "联系电话：".$res['tel']."\n";
	if($res['is_zt']==1){
		$content .= "自提时间：".$res['zt_time']."\n";
	}else{
		$content .= "收货地址：".$res['address']."\n";
	}
	
	if($res['note']){
		$content .= "备注".$res['note']."\n";
	}
	
	$content .= "下单时间：".$res['time']."\n";

// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
		//echo 1;die;
if($res3['type']==1){//365打印

	$selfMessage = array(
		'deviceNo'=>$res3['dyj_id'],  
		'printContent'=>$content,
		'key'=>$res3['dyj_key'],
		'times'=>'1'
		);        
	$url = "http://open.printcenter.cn:8080/addOrder";
	$options = array(
		'http' => array(
			'header' => "Content-type: application/x-www-form-urlencoded",
			'method'  => 'POST',
			'content' => http_build_query($selfMessage),
			),
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	return $result;
}
if($res3['type']==2){//易联云
	include("print.class.php");
	$print = new Yprint();
	$apiKey = $res3['api'];
	$msign = $res3['token'];
	$partner=$res3['yy_id'];
	$machine_code=$res3['mid'];

//打印
	$print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
}
public function doPagePrint(){ // $times打印次数
	global $_W, $_GPC;
	$res=pdo_get('zhvip_order',array('id'=>$_GPC['order_id']));
	$res3=pdo_get('zhvip_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1));
	$store=pdo_get('zhvip_store',array('id'=>$res['store_id']));


	if($res['pay_type']==1){
		$pay_type="微信支付";
	}elseif($res['pay_type']==2){
		$pay_type="余额支付";
	}elseif($res['pay_type']==3){
		$pay_type="积分支付";
	}
	$content = "\n\n\n\n";
	$content .= "         订单编号  #".$res['id']." \n\n";
	$content .= "          ".$res3['dyj_title']."\n\n";
	$content .= "------------".$pay_type."------------\n";
	$content .= "------------".$store['name']."------------\n";
	$content .= "--------------------------------\n";
	$content .= "优惠：　　　　　　　　 -".$res['preferential']."\n";
	$content .= "--------------------------------\n";
	$content .= "已付：　　　　　　　　　".$res['money']."\n";
	$content .= "--------------------------------\n";
	$content .= "下单时间：".$res['time']."\n";

// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
		//echo 1;die;
if($res3['type']==1){//365打印

	$selfMessage = array(
		'deviceNo'=>$res3['dyj_id'],  
		'printContent'=>$content,
		'key'=>$res3['dyj_key'],
		'times'=>'1'
		);        
	$url = "http://open.printcenter.cn:8080/addOrder";
	$options = array(
		'http' => array(
			'header' => "Content-type: application/x-www-form-urlencoded",
			'method'  => 'POST',
			'content' => http_build_query($selfMessage),
			),
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	return $result;
}
if($res3['type']==2){//易联云
	include("print.class.php");
	$print = new Yprint();
	$apiKey = $res3['api'];
	$msign = $res3['token'];
	$partner=$res3['yy_id'];
	$machine_code=$res3['mid'];

//打印
	$print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
}

public function doPageCzPrint(){ // $times打印次数
	global $_W, $_GPC;
	$res=pdo_get('zhvip_czorder',array('id'=>$_GPC['order_id']));
	$res3=pdo_get('zhvip_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1));
	$store=pdo_get('zhvip_store',array('id'=>$res['store_id']));
	$content = "\n\n\n\n";
	$content = "^N2\n";
	$content .= "         订单编号  #".$res['id']." \n\n";
	$content .= "          ".$res3['dyj_title']."\n\n";
	$content .= "------------".$store['name']."------------\n";
	$content .= "充值金额：　　　　　　　　 ".$res['money']."\n";
	$content .= "--------------------------------\n";
	$content .= "赠送金额：　　　　　　　　 ".$res['money2']."\n";
	$content .= "--------------------------------\n";
	$content .= "充值时间：".$res['time']."\n";
if($res3['type']==1){//365打印
	$selfMessage = array(
		'deviceNo'=>$res3['dyj_id'],  
		'printContent'=>$content,
		'key'=>$res3['dyj_key'],
		'times'=>'1'
		);        
	$url = "http://open.printcenter.cn:8080/addOrder";
	$options = array(
		'http' => array(
			'header' => "Content-type: application/x-www-form-urlencoded",
			'method'  => 'POST',
			'content' => http_build_query($selfMessage),
			),
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	return $result;
}
if($res3['type']==2){//易联云
	include("print.class.php");
	$print = new Yprint();
	$apiKey = $res3['api'];
	$msign = $res3['token'];
	$partner=$res3['yy_id'];
	$machine_code=$res3['mid'];

//打印
	$print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
}


public function doPageCzPrint2(){ // $times打印次数
	global $_W, $_GPC;
	$res=pdo_get('zhvip_czorder',array('id'=>$_GPC['order_id']));
	$res3=pdo_get('zhvip_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1));
	$store=pdo_get('zhvip_store',array('id'=>$res['store_id']));
	$content = "\n\n\n\n";
	$content = "^N2\n";
	$content .= "         订单编号  #".$res['id']." \n\n";
	$content .= "          ".$res3['dyj_title']."\n\n";
	$content .= "------------".$store['name']."------------\n";
	$content .= "充值金额：　　　　　　　　 ".$res['money']."\n";
	$content .= "--------------------------------\n";
	$content .= "付款方式：　　　　　　　　 ".$res['pay_type']."\n";
	$content .= "--------------------------------\n";
	$content .= "充值时间：".$res['time']."\n";
if($res3['type']==1){//365打印
	$selfMessage = array(
		'deviceNo'=>$res3['dyj_id'],  
		'printContent'=>$content,
		'key'=>$res3['dyj_key'],
		'times'=>'1'
		);        
	$url = "http://open.printcenter.cn:8080/addOrder";
	$options = array(
		'http' => array(
			'header' => "Content-type: application/x-www-form-urlencoded",
			'method'  => 'POST',
			'content' => http_build_query($selfMessage),
			),
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	return $result;
}
if($res3['type']==2){//易联云
	include("print.class.php");
	$print = new Yprint();
	$apiKey = $res3['api'];
	$msign = $res3['token'];
	$partner=$res3['yy_id'];
	$machine_code=$res3['mid'];

//打印
	$print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
}





//积分明细
public function doPageJfmx(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_jfmx',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
	echo json_encode($res);
}




//商品分类
public function doPageJftype(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_jftype',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
	echo json_encode($res);
}
  //分类列表
	public function doPageDishesType(){
		global $_W, $_GPC;
		$type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id'],'state'=>1),array(),'','num ASC');
    // $list=pdo_getall('zhvip_goods',array('uniacid'=>$_W['uniacid'],'is_show'=>1,'type='=>$_GPC['type'],'store_id'=>$_GPC['id']),array(),'','sorting ASC');
    //var_dump($type);die;
		$data=array();
		for($i=0;$i<count($type);$i++){
			$list=pdo_getall('zhvip_goods',array('uniacid'=>$_W['uniacid'],'is_show'=>1,'t_id'=>$type[$i]['id'],'store_id'=>$_GPC['store_id']),array(),'','num ASC');
			if($list){
				$data[]=array(
					'id'=>$type[$i]['id'],
					'type_name'=>$type[$i]['name'],
					'good'=>array()
					);
			}

		}
		echo json_encode($data);
	}
  //分类下菜品
	public function doPageDishes(){
		global $_W, $_GPC;
		$sql="select * from " . tablename("zhvip_goods") . "  WHERE t_id={$_GPC['type_id']}  and is_show=1";
		$res=pdo_fetchall($sql);
		echo json_encode($res);
	}
//商品列表
public function doPageJfGoods(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_jfgoods',array('uniacid'=>$_W['uniacid'],'is_open'=>1),array(),'','num asc');
	echo json_encode($res);
}
 //商品详情
public function doPageJfGoodsInfo(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_jfgoods',array('id'=>$_GPC['id']));

	echo json_encode($res); 
}
 //分类下的商品
public function doPageJftypeGoods(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_jfgoods',array('type_id'=>$_GPC['type_id'],'is_open'=>1),array(),'','num asc');
	echo json_encode($res);
}
//积分商城广告
public function doPageAd3(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_ad',array('uniacid'=>$_W['uniacid'],'status'=>1,'type'=>2),array(),'','orderby asc');
	echo json_encode($res);
}
//积分商城广告
public function doPageMyAd(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_ad',array('uniacid'=>$_W['uniacid'],'status'=>1,'type'=>3),array(),'','orderby asc');
	echo json_encode($res);
}
//兑换商品
public function doPageExchange(){
	global $_W, $_GPC;
			$data['user_id']=$_GPC['user_id'];//用户id
			$data['good_id']=$_GPC['good_id'];//商品id
			$data['user_name']=$_GPC['user_name'];//用户名称
			$data['user_tel']=$_GPC['user_tel'];//用户电话
			$data['address']=$_GPC['address'];//地址
			$data['integral']=$_GPC['integral'];//积分
			if($_GPC['type']==1){//虚拟红包
				$data['state']=2;
			}else{
				$data['state']=1;
			}
			
			$data['good_name']=$_GPC['good_name'];//商品名称
			$data['good_img']=$_GPC['good_img'];//商品图片
			$data['time']=date("Y-m-d H:i:s");
			$res=pdo_insert('zhvip_jfrecord',$data);
			$jfid=pdo_insertid();
			file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=JfMessage&m=zh_vip&id=".$jfid);//模板消息
					
			if($res){
				pdo_update('zhvip_jfgoods',array('number -='=>1),array('id'=>$_GPC['good_id']));
					if($_GPC['type']==1){//虚拟红包
						pdo_update('zhvip_user',array('wallet +='=>$_GPC['hb_money']),array('id'=>$_GPC['user_id']));
						$data2['money']=$_GPC['hb_money'];
						$data2['user_id']=$_GPC['user_id'];
						$data2['type']=1;
						$data2['note']='积分兑换';
						$data2['time']=date('Y-m-d H:i:s');
						pdo_insert('zhvip_qbmx',$data2);
							$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
					}
					$data3['score']=$_GPC['integral'];
					$data3['user_id']=$_GPC['user_id'];
					$data3['note']='兑换商品';
					$data3['type']=2;
					$data3['cerated_time']=date('Y-m-d H:i:s');
					$data3['uniacid']=$_W['uniacid'];//小程序id
					pdo_insert('zhvip_jfmx',$data3); 
					pdo_update('zhvip_user',array('integral -='=>$_GPC['integral']),array('id'=>$_GPC['user_id']));
					echo '1';
				}else{
					echo '2';
				}
			}
	//兑换明细
			public function doPageDhmx(){
				global $_W, $_GPC;
				$res=pdo_getall('zhvip_jfrecord',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
				echo json_encode($res);
			}

			//商品详情
			public function doPageGoodInfo(){
				global $_W, $_GPC;
				 // $_GPC['good_id']=2;
				$good=pdo_get('zhvip_goods',array('id'=>$_GPC['good_id'],'uniacid'=>$_W['uniacid']));
				$spec=pdo_getall('zhvip_spec',array('good_id'=>$_GPC['good_id'],'uniacid'=>$_W['uniacid']),array(),'','num asc');
				$specval=pdo_getall('zhvip_spec_val',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
				$data2=array();
				for($i=0;$i<count($spec);$i++){
					$data=array();
					for($k=0;$k<count($specval);$k++){
						if($spec[$i]['id']==$specval[$k]['spec_id']){
							$data[]=array(
								'spec_val_id'=>$specval[$k]['id'],
								'spec_val_name'=>$specval[$k]['name'],
								'spec_val_num'=>$specval[$k]['num']
								);
						}           
					}
					$data2[]=array(
						'spec_id'=>$spec[$i]['id'],
						'spec_name'=>$spec[$i]['name'],
						'spec_num'=>$spec[$i]['num'],
						'spec_val'=>$data
						);
				}
				if(strlen($good['img'])>51){
					$good['img']= explode(',',$good['img']);
				}else{
					$good['img']=array(
						0=>$good['img']
						);
				}  

				$good['spec']=$data2;
				echo json_encode($good);
				 // print_r($good);

			}
			//评价列表
			public function doPagePjList(){
				global $_W, $_GPC;
				$where="WHERE  good_id=".$_GPC['good_id'];
				if($_GPC['score']){
					$where .=" and  score=".$_GPC['score'];
				}
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize=$_GPC['pagesize'];
				$sql="SELECT *  FROM ".tablename('zhvip_assess').$where;
				$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize; 
				$list=pdo_fetchall($select_sql);
				echo json_encode($list);
			}
			//评论数量
			public function doPagePjNum(){
				global $_W, $_GPC;
				$res=count(pdo_getall('zhvip_assess',array('good_id'=>$_GPC['good_id'])));//全部
				$res2=count(pdo_getall('zhvip_assess',array('good_id'=>$_GPC['good_id'],'score'=>1)));//好评
				$res3=count(pdo_getall('zhvip_assess',array('good_id'=>$_GPC['good_id'],'score'=>2)));//中评
				$res4=count(pdo_getall('zhvip_assess',array('good_id'=>$_GPC['good_id'],'score'=>3)));//差评
				$data['all']=$res;
				$data['good']=$res2;
				$data['medium']=$res3;
				$data['bad']=$res4;
				echo  json_encode($data);
			}

			//规格组合
			public function doPageGgZh(){
				global $_W, $_GPC;
				$res=pdo_get('zhvip_spec_combination',array('combination'=>$_GPC['combination'],'good_id'=>$_GPC['good_id']));
				echo json_encode($res);
			}
			//分类列表
			public function doPageType(){
				global $_W, $_GPC;
				$type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id'],'state'=>1),array(),'','num asc');
				$list=pdo_getall('zhvip_type2',array('state'=>1,'uniacid'=>$_W['uniacid']),array(),'','num asc');
				$data2=array();
				for($i=0;$i<count($type);$i++){
					$data=array();
					for($k=0;$k<count($list);$k++){
						if($type[$i]['id']==$list[$k]['type_id']){
							$data[]=array(
								'id'=>$list[$k]['id'],
								'name'=>$list[$k]['type_name'],
								'img'=>$list[$k]['img'],
								);
						}           
					}
					$data2[]=array(
						'id'=>$type[$i]['id'],
						'name'=>$type[$i]['name'],
						'type2'=>$data
						);
				}
				echo json_encode($data2);
			}
			//分类下的商品
			public function doPageGoods(){
				global $_W, $_GPC;
				$where=" WHERE uniacid=:uniacid and is_show=1";
				if($_GPC['type_id']){
					$where .=" and type_id=:type_id";
					$data[':type_id']=$_GPC['type_id'];
				}
				if($_GPC['name']){
					$where .=" and name LIKE  concat('%', :name,'%')";
					$data[':name']=$_GPC['name'];      
				}
				$data[':uniacid']=$_W['uniacid'];
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize=$_GPC['pagesize'];
				if($_GPC['order']=='sales'){
					$sql="select *  from " . tablename("zhvip_goods") . "".$where." order by sales DESC";
				}elseif($_GPC['by']=='asc' and $_GPC['order']=='minprice'){
					$sql="select *  from " . tablename("zhvip_goods") . "".$where." order by money asc";
				}elseif($_GPC['by']=='desc' and $_GPC['order']=='minprice'){
					$sql="select *  from " . tablename("zhvip_goods") . "".$where." order by money desc";
				}else{
					$sql="select *  from " . tablename("zhvip_goods") . "".$where." order by num asc";
				}
				$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
				$res=pdo_fetchall($select_sql,$data);
				echo json_encode($res);
			}
			//添加购物车
			public function doPageAddCar(){
				global $_W, $_GPC;
				$good=pdo_get('zhvip_shopcar',array('good_id'=>$_GPC['good_id'],'store_id'=>$_GPC['store_id'],'user_id'=>$_GPC['user_id'],'combination_id'=>$_GPC['combination_id']));
				$combination=pdo_get('zhvip_spec_combination',array('id'=>$_GPC['combination_id']));
				$list=pdo_get('zhvip_goods',array('id'=>$_GPC['good_id']));
				if($_GPC['combination_id']){
					$kc=$combination['number'];
				}else{
					$kc=$list['inventory'];
				}
				if(($_GPC['num']+$good['num'])>$kc){
					echo '超出库存!';
				}else{
					if($good){
						$data['num']=$_GPC['num']+$good['num'];
						$res=pdo_update('zhvip_shopcar',$data,array('id'=>$good['id']));
					}else{
						$data['good_id']=$_GPC['good_id'];
						$data['store_id']=$_GPC['store_id'];
						$data['user_id']=$_GPC['user_id'];
						$data['num']=$_GPC['num'];
						$data['spec']=$_GPC['spec'];
						$data['money']=$_GPC['money'];
						$data['combination_id']=$_GPC['combination_id'];				
						$res=pdo_insert('zhvip_shopcar',$data);
					}
					if($res){
						echo  '1';
					}else{
						echo  '2';
					}
				}				
			}
			//删除购物车
			public function doPageDelCar(){
				global $_W, $_GPC;
				//print_r($_GPC['id']);die;
				$_GPC['id']= explode(',',$_GPC['id']);
				$res=pdo_delete('zhvip_shopcar',array('id'=>$_GPC['id']));
				if($res){
					echo '1';
				}else{
					echo '2';
				}
			}
						//清空购物车
	public function doPageDelCar2(){
		global $_W, $_GPC;
		$res=pdo_delete('zhvip_shopcar',array('user_id'=>$_GPC['user_id'],'store_id'=>$_GPC['store_id']));
		if($res){
			echo '1';
		}else{
			echo '2';
		}
	}
			//修改购物车
			public function doPageUpdCar(){
				global $_W, $_GPC;
				$car=pdo_get('zhvip_shopcar',array('id'=>$_GPC['id']));
				$combination=pdo_get('zhvip_spec_combination',array('id'=>$car['combination_id']));
				$list=pdo_get('zhvip_goods',array('id'=>$car['good_id']));
				if($car['combination_id']){
					$kc=$combination['number'];
				}else{
					$kc=$list['inventory'];
				}
				if(($_GPC['num'])>$kc){
					echo '超出库存!';
				}else{
					if($_GPC['num']==0){
						$res=pdo_delete('zhvip_shopcar',array('id'=>$_GPC['id']));
						if($res){
							echo '1';
						}else{
							echo '2';
						}
					}else{
						$res=pdo_update('zhvip_shopcar',array('num'=>$_GPC['num']),array('id'=>$_GPC['id']));
						if($res){
							echo '1';
						}else{
							echo '2';
						}
					}

				}
			}
			//我的购物车
			public function doPageMyCar(){
				global $_W, $_GPC;
				$sql="select a.*,b.number,c.logo,c.name,c.inventory from " . tablename("zhvip_shopcar") . " a"  . " left join " . tablename("zhvip_spec_combination") . " b on b.id=a.combination_id " . " left join " . tablename("zhvip_goods") . " c on c.id=a.good_id  WHERE a.store_id=:store_id and a.user_id=:user_id ";
				$res=pdo_fetchall($sql,array('store_id'=>$_GPC['store_id'],'user_id'=>$_GPC['user_id']));
				echo json_encode($res);
			}
			//我的购物车数量
			public function doPageMyCarNum(){
				global $_W, $_GPC;
				$sql="select a.*,b.number,c.logo,c.name from " . tablename("zhvip_shopcar") . " a"  . " left join " . tablename("zhvip_spec_combination") . " b on b.id=a.combination_id " . " left join " . tablename("zhvip_goods") . " c on c.id=a.good_id  WHERE a.store_id=:store_id and a.user_id=:user_id ";
				$res=pdo_fetchall($sql,array('store_id'=>$_GPC['store_id'],'user_id'=>$_GPC['user_id']));
				$num=0;
				for($i=0;$i<count($res);$i++){
					$num=$res[$i]['num']+$num;
				}
				echo  $num;
			}
			//我的默认地址
			public function doPageMyDefaultAddress(){
				global $_W, $_GPC;
				$res=pdo_get('zhvip_useradd',array('user_id'=>$_GPC['user_id'],'is_default'=>1));
				
				echo json_encode($res);
			}
			//我的地址
			public function doPageMyAddress(){
				global $_W, $_GPC;
				$res=pdo_getall('zhvip_useradd',array('user_id'=>$_GPC['user_id']));
				for($i=0;$i<count($res);$i++){
					$res[$i]['area']=explode(',',$res[$i]['area']);
				}
				echo json_encode($res);
			}
			//我的地址详情
			public function doPageMyAddressInfo(){
				global $_W, $_GPC;
				$res=pdo_get('zhvip_useradd',array('id'=>$_GPC['id']));
				$res['area']=explode(',',$res['area']);
				echo json_encode($res);
			}
			//添加地址
			public function doPageAddAddress(){
				global $_W, $_GPC;
				$data['address']=$_GPC['address'];
				$data['area']=$_GPC['area'];
				$data['user_name']=$_GPC['user_name'];
				$data['user_id']=$_GPC['user_id'];
				$data['tel']=$_GPC['tel'];
				$data['is_default']=2;
				$res=pdo_insert('zhvip_useradd',$data);
				if($res){
					echo '1';
				}else{
					echo '2'; 
				}
			}
			//修改地址
			public function doPageUpdAddress(){
				global $_W, $_GPC;
				$data['address']=$_GPC['address'];
				$data['area']=$_GPC['area'];
				$data['user_name']=$_GPC['user_name'];
				$data['tel']=$_GPC['tel'];
				$res=pdo_update('zhvip_useradd',$data,array('id'=>$_GPC['id']));
				if($res){
					echo '1';
				}else{
					echo '2'; 
				}
			}
			//设为默认
			public function doPageAddDefault(){
				global $_W, $_GPC;
				$data['is_default']=1;
				$res=pdo_update('zhvip_useradd',$data,array('id'=>$_GPC['id']));
				$add=pdo_get('zhvip_useradd',array('id'=>$_GPC['id']));
				if($res){
					pdo_update('zhvip_useradd',array('is_default'=>2),array('id !='=>$_GPC['id'],'user_id'=>$add['user_id']));
					echo '1';
				}else{
					echo '2'; 
				}
			}
			//删除地址
			public function doPageDelAdd(){
				global $_W, $_GPC;
				$res=pdo_delete('zhvip_useradd',array('id'=>$_GPC['id']));
				if($res){
					echo '1';
				}else{
					echo '2'; 
				}
			}
			//下商城订单
			public function doPageAddShopOrder(){
				global $_W, $_GPC;
				if($_GPC['pay_type']==2){//余额支付
					$data2['money']=$_GPC['money'];
					$data2['user_id']=$_GPC['user_id'];
					$data2['store_id']=$_GPC['store_id'];
					$data2['type']=2;
					$data2['note']='商城消费';
					$data2['time']=date('Y-m-d H:i:s');
				 $data2['uniacid']=$_W['uniacid'];//小程序id
				 $res2=pdo_insert('zhvip_qbmx',$data2);
				 	$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
				 if($res2){
					pdo_update('zhvip_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));//减余额
					$data['order_num']=date('YmdHis',time()).rand(1111,9999);
				 	$data['money']=$_GPC['money'];//金额
				 	$data['price']=$_GPC['price'];//原价
				 	$data['preferential']=$_GPC['preferential'];//折扣金额
				 	$data['preferential2']=$_GPC['preferential2'];//优惠券折扣金额
				 	$data['user_id']=$_GPC['user_id'];//用户id
				 	$data['store_id']=$_GPC['store_id'];//商家id
				 	$data['time']=date("Y-m-d H:i:s");
				 	$data['pay_type']=$_GPC['pay_type'];//1.微信2.余额3.积分
				 	$data['is_zt']=$_GPC['is_zt'];//1.自提2.不自提
				 	$data['zt_time']=$_GPC['zt_time'];//自提时间
				 	if($_GPC['is_zt']==1){
				 		$data['state']=3;
				 	}else{
				 		$data['state']=2;
				 	}
				 	$data['pay_time']=time();
				 	$data['form_id']=$_GPC['form_id'];
				 	$data['form_id2']=$_GPC['form_id2'];
				 	$data['freight']=$_GPC['freight'];
				 	$data['note']=$_GPC['note'];//备注
				 	$data['address']=$_GPC['address'];//地址
				 	$data['tel']=$_GPC['tel'];//电话
				 	$data['user_name']=$_GPC['user_name'];//联系人
				 	$data['uniacid']=$_W['uniacid'];
				 	$res=pdo_insert('zhvip_shoporder',$data);
				 	$order_id=pdo_insertid();
				 	$a=json_decode(html_entity_decode($_GPC['sz']));
				 	$sz=json_decode(json_encode($a),true);


				 	if($res){
				 		if($_GPC['coupons_id']){
				 			pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
				 		}
				 		pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
				 		$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
				 		$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
				 		$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
				 		if($level){
				 			$money=$user['level_cumulative'];
				 			for($i=0;$i<count($level);$i++){
				 				if(($money-$level[$i]['threshold'])>=0){
				 					$money=$money-$level[$i]['threshold'];
				 					pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id'])); 
				 					file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
				 				}else{
				 					break;
				 				}
				 			}
				 		}
				 		for($j=0;$j<count($sz);$j++){
				 			$data3['name']=$sz[$j]['name'];
				 			$data3['number']=$sz[$j]['num'];
				 			$data3['money']=$sz[$j]['money'];
				 			$data3['spec']=$sz[$j]['spec'];
				 			$data3['img']=$sz[$j]['img'];
				 			$data3['good_id']=$sz[$j]['good_id'];
		            $data3['uniacid']=$_W['uniacid'];//小程序id
		            $data3['order_id']=$order_id;
		            $res2=pdo_insert('zhvip_ordergoods',$data3);
		            pdo_delete('zhvip_shopcar',array('id'=>$sz[$j]['car_id']));

		            pdo_update('zhvip_goods',array('sales +='=>$sz[$j]['num'],'inventory -='=>$sz[$j]['num']),array('id'=>$sz[$j]['good_id']));
		        }
		        file_get_contents("".$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=Sms2&m=zh_vip&store_id=".$_GPC['store_id']);//短信
		        file_get_contents("".$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=Print2&m=zh_vip&order_id=".$order_id);//打印
		        echo $order_id;
		    }else{
		    	echo '下单失败';
		    }
		}
				}elseif($_GPC['pay_type']==1){//微信支付
					$data['order_num']=date('YmdHis',time()).rand(1111,9999);
					$data['money']=$_GPC['money'];
					$data['price']=$_GPC['price'];
					$data['preferential']=$_GPC['preferential'];
					$data['preferential2']=$_GPC['preferential2'];
					$data['user_id']=$_GPC['user_id'];
					$data['store_id']=$_GPC['store_id'];
					$data['time']=date("Y-m-d H:i:s");
					$data['pay_type']=$_GPC['pay_type'];
					$data['state']=1;
					$data['form_id']=$_GPC['form_id'];
					$data['form_id2']=$_GPC['form_id2'];
					$data['note']=$_GPC['note'];
					$data['address']=$_GPC['address'];
					$data['tel']=$_GPC['tel'];
					$data['user_name']=$_GPC['user_name'];
					$data['is_zt']=$_GPC['is_zt'];
					 	$data['zt_time']=$_GPC['zt_time'];//自提时间
					 	$data['freight']=$_GPC['freight'];
					 	$data['uniacid']=$_W['uniacid'];
					 	$res=pdo_insert('zhvip_shoporder',$data);
					 	$order_id=pdo_insertid();
					 	$a=json_decode(html_entity_decode($_GPC['sz']));
					 	$sz=json_decode(json_encode($a),true);
					 	if($res){
					 		for($j=0;$j<count($sz);$j++){
					 			$data3['name']=$sz[$j]['name'];
					 			$data3['number']=$sz[$j]['num'];
					 			$data3['money']=$sz[$j]['money'];
					 			$data3['spec']=$sz[$j]['spec'];
					 			$data3['img']=$sz[$j]['img'];
					 			$data3['good_id']=$sz[$j]['good_id'];
		            $data3['uniacid']=$_W['uniacid'];//小程序id
		            $data3['order_id']=$order_id;
		            $res2=pdo_insert('zhvip_ordergoods',$data3);
		            pdo_delete('zhvip_shopcar',array('id'=>$sz[$j]['car_id']));
		        }
		        if($_GPC['coupons_id']){
		 			pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
				 }
		        echo $order_id;
		    }else{
		    	echo '下单失败';
		    }
			}elseif($_GPC['pay_type']==3){//积分支付
				$data2['score']=$_GPC['jf'];
				$data2['user_id']=$_GPC['user_id'];
				$data2['note']='商城消费';
				$data2['type']=2;
				$data2['cerated_time']=date('Y-m-d H:i:s');
				$data2['uniacid']=$_W['uniacid'];//小程序id
				$res2=pdo_insert('zhvip_jfmx',$data2);
				if($res2){
						pdo_update('zhvip_user',array('integral -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));//减余额
						$data['order_num']=date('YmdHis',time()).rand(1111,9999);
						$data['money']=$_GPC['money'];
						$data['price']=$_GPC['price'];
						$data['preferential']=$_GPC['preferential'];
						$data['preferential2']=$_GPC['preferential2'];
						$data['user_id']=$_GPC['user_id'];
						$data['store_id']=$_GPC['store_id'];
						$data['time']=date("Y-m-d H:i:s");
						$data['pay_type']=$_GPC['pay_type'];
						if($_GPC['is_zt']==1){
							$data['state']=3;
						}else{
							$data['state']=2;
						}
						$data['pay_time']=time();
						$data['form_id']=$_GPC['form_id'];
						$data['form_id2']=$_GPC['form_id2'];
						$data['note']=$_GPC['note'];
						$data['address']=$_GPC['address'];
						$data['tel']=$_GPC['tel'];
						$data['user_name']=$_GPC['user_name'];
						$data['is_zt']=$_GPC['is_zt'];
					 	$data['zt_time']=$_GPC['zt_time'];//自提时间
					 	$data['uniacid']=$_W['uniacid'];
					 	$data['freight']=$_GPC['freight'];
					 	$res=pdo_insert('zhvip_shoporder',$data);
					 	$order_id=pdo_insertid();
					 	$a=json_decode(html_entity_decode($_GPC['sz']));
					 	$sz=json_decode(json_encode($a),true);
					 	if($res){
					 		if($_GPC['coupons_id']){
					 			pdo_update('zhvip_usercoupons',array('state'=>1,'use_time'=>date("Y-m-d H:i:s")),array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
					 		}
					 		pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
					 		$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
					 		$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
					 		$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
					 		if($level){
					 			$money=$user['level_cumulative'];
					 			for($i=0;$i<count($level);$i++){
					 				if(($money-$level[$i]['threshold'])>=0){
					 					$money=$money-$level[$i]['threshold'];
					 					pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id'])); 
					 					file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
					 				}else{
					 					break;
					 				}
					 			}
					 		}
					 		for($j=0;$j<count($sz);$j++){
					 			$data3['name']=$sz[$j]['name'];
					 			$data3['number']=$sz[$j]['num'];
					 			$data3['money']=$sz[$j]['money'];
					 			$data3['spec']=$sz[$j]['spec'];
					 			$data3['img']=$sz[$j]['img'];
					 			$data3['good_id']=$sz[$j]['good_id'];
					            $data3['uniacid']=$_W['uniacid'];//小程序id
					            $data3['order_id']=$order_id;
					            $res2=pdo_insert('zhvip_ordergoods',$data3);
					            pdo_delete('zhvip_shopcar',array('id'=>$sz[$j]['car_id']));
					        }
					       file_get_contents("".$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=Sms2&m=zh_vip&store_id=".$_GPC['store_id']);//短信
					       file_get_contents("".$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=Print2&m=zh_vip&order_id=".$order_id);//打印
					        echo $order_id;
					    }else{
					    	echo '下单失败';
					    }
					}
				}



			}

//我的订单
			public function  doPageMyMallOrder(){
				global $_W, $_GPC;
				$where=" WHERE a.user_id=".$_GPC['user_id']." and a.state in (".$_GPC['state'].") and is_del=2";
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize=$_GPC['pagesize'];
				$sql="select  a.*,b.name as store_name,b.md_img,b.tel as store_tel  from " . tablename("zhvip_shoporder")  . " a"  . " left join " . tablename("zhvip_store") . " b on b.id=a.store_id ".$where." order by a.id DESC";
				$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
				$list = pdo_fetchall($select_sql);
	//	$list=pdo_getall('zhvip_shoporder',array('user_id'=>$_GPC['user_id'],'store_id'=>$_GPC['store_id'],'state'=>$_GPC['state']));
				$good=pdo_getall('zhvip_ordergoods',array('uniacid'=>$_W['uniacid']));
				$data2=array();
				for($i=0;$i<count($list);$i++){
					$data=array();
					for($k=0;$k<count($good);$k++){
						if($list[$i]['id']==$good[$k]['order_id']){
							$data[]=array(
								'good_id'=>$good[$k]['good_id'],
								'img'=>$good[$k]['img'],
								'number'=>$good[$k]['number'],
								'name'=>$good[$k]['name'],
								'money'=>$good[$k]['money'],
								'spec'=>$good[$k]['spec']
								);
						}
					}
					$data2[]=array(
						'store_tel'=>$list[$i]['store_tel'],
						'order_id'=>$list[$i]['id'],
						'md_img'=>$list[$i]['md_img'],
						'store_name'=>$list[$i]['store_name'],
						'order_num'=>$list[$i]['order_num'],
						'money'=>$list[$i]['money'],
						'price'=>$list[$i]['price'],
						'preferential'=>$list[$i]['preferential'],	
						'preferential2'=>$list[$i]['preferential2'],
						'user_id'=>$list[$i]['user_id'],
						'store_id'=>$list[$i]['store_id'],
						'time'=>$list[$i]['time'],
						'pay_type'=>$list[$i]['pay_type'],
						'coupons_id'=>$list[$i]['coupons_id'],
						'state'=>$list[$i]['state'],
						'form_id'=>$list[$i]['form_id'],
						'note'=>$list[$i]['note'],
						'address'=>$list[$i]['address'],
						'tel'=>$list[$i]['tel'],
						'user_name'=>$list[$i]['user_name'],
						'is_zt'=>$list[$i]['is_zt'],
						'good'=>$data
						);
				}
		//print_r($data2);die;
				echo  json_encode($data2);
			}
//删除订单
			public function doPageDelMallOrder(){
				global $_W, $_GPC;
				$res=pdo_update('zhvip_shoporder',array('is_del'=>1),array('id'=>$_GPC['order_id']));
				if($res){
					echo '1';
				}else{
					echo '2';
				}
			}
	//退款
			public function doPageTkMallOrder(){
				global $_W, $_GPC;
				$res=pdo_update('zhvip_shoporder',array('state'=>6),array('id'=>$_GPC['order_id']));
				if($res){
					echo '1';
				}else{
					echo '2';
				}
			}
	//确认收货
			public function doPageShMallOrder(){
				global $_W, $_GPC;
				$order=pdo_get('zhvip_shoporder',array('id'=>$_GPC['order_id']));
				$res=pdo_update('zhvip_shoporder',array('state'=>4,'complete_time'=>date("Y-m-d H:i:s")),array('id'=>$_GPC['order_id']));
				if($res){
					///////////加积分//////////////
		         $system=pdo_get('zhvip_system',array('uniacid'=>$order['uniacid']));
		         if($system['is_jf']==1){
		         	 $jifen=round(($system['integral']/100)*$order['money']);
		         	 pdo_update('zhvip_user',array('integral +='=>$jifen),array('id'=>$order['user_id']));
		         	 $data['score']=$jifen;
		            $data['user_id']=$order['user_id'];
		            $data['note']='商城订单';
		            $data['type']=1;
		            $data['cerated_time']=date('Y-m-d H:i:s');
		            $data['uniacid']=$order['uniacid'];//小程序id
		            pdo_insert('zhvip_jfmx',$data);
		         }
		         ///////////加积分//////////////
		         //////////升级//////////////
		         pdo_update('zhvip_user',array('cumulative +='=>$order['money'],'level_cumulative +='=>$order['money']),array('id'=>$order['user_id']));
				$user=pdo_get('zhvip_user',array('id'=>$order['user_id']));
				$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
				$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
				if($level){
					$money=$user['level_cumulative'];
					for($i=0;$i<count($level);$i++){
						if(($money-$level[$i]['threshold'])>=0){
							$money=$money-$level[$i]['threshold'];
							pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$order['user_id'])); 
							file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
						}else{
						 break;
					 }
				 }
			 }
			 //////////升级//////////////
					echo '1';
				}else{
					echo '2';
				}
			}
	//订单详情
			public function doPageMallOrderInfo(){
				global $_W, $_GPC;
				$res=pdo_get('zhvip_shoporder',array('id'=>$_GPC['order_id']));
				$good=pdo_getall("zhvip_ordergoods",array('order_id'=>$_GPC['order_id']));
				$data['order']=$res;
				$data['good']=$good;
				echo json_encode($data);
			}

//商城设置
			public function doPageMallSet(){
				global $_W, $_GPC;
				$res=pdo_get('zhvip_mallset',array('store_id'=>$_GPC['store_id']));
				echo json_encode($res);
			}	

//评论
			public function doPageAssess(){
				global $_W, $_GPC;
				$a=json_decode(html_entity_decode($_GPC['sz']));
				$sz=json_decode(json_encode($a),true);
				for($i=0;$i<count($sz);$i++){
        	$data['user_id']=$sz[$i]['user_id'];//用户id
			$data['user_name']=$sz[$i]['user_name'];//用户昵称
			$data['user_img']=$sz[$i]['user_img'];//用户头像
			$data['store_id']=$sz[$i]['store_id'];//商家id
			$data['good_id']=$sz[$i]['good_id'];//商品id
			$data['spec']=$sz[$i]['spec'];//规格
			$data['score']=$sz[$i]['score'];//1.好评 2.中评 3.差评
			$data['content']=$sz[$i]['content'];//评论内容
			$data['img']=$sz[$i]['img'];//评论图片
			$data['status']=1;
			$data['cerated_time']=date("Y-m-d H:i:s");
			$data['uniacid']=$_W['uniacid'];
			$res=pdo_insert('zhvip_assess',$data);
		}
		$upd=pdo_update('zhvip_shoporder',array('state'=>5),array('id'=>$_GPC['order_id']));
		if($upd){
			echo '1';
		}else{
			echo '2';
		}
	}

//商城下订单发短信
public function doPageSms2(){
    global $_W, $_GPC;
    $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    $store=pdo_get('zhvip_store',array('id'=>$_GPC['store_id']));
    $tpl_id=$res['tpl2_id'];
    $tel=$store['sms_tel'];
    $key=$res['appkey'];
    $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D654654&key=".$key;
    $data=file_get_contents($url);
    print_r($data);
  }

//充值发短信
public function doPageSms3(){
    global $_W, $_GPC;
    $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    $store=pdo_get('zhvip_store',array('id'=>$_GPC['store_id']));
    $tpl_id=$res['tpl3_id'];
    $tel=$store['sms_tel'];
    $key=$res['appkey'];
    $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D654654&key=".$key;
    $data=file_get_contents($url);
    print_r($data);
}













 //上传图片
	public function doPageUpload(){
		global $_W, $_GPC;
		$uptypes=array(  
			'image/jpg',  
			'image/jpeg',  
			'image/png',  
			'image/pjpeg',  
			'image/gif',  
			'image/bmp',  
			'image/x-png'  
			);  
    $max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
 //   $destination_folder="../attachment/zh_tcwq/".$_W['uniacid']."/".date(Y)."/".date(m)."/".date(d)."/"; //上传文件路径  
 $destination_folder="../attachment/"; //上传文件路径  
    $watermark=2;      //是否附加水印(1为加水印,其他为不加水印);  
    $watertype=1;      //水印类型(1为文字,2为图片)  
    $waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
    $waterstring="666666";  //水印字符串  
    // $waterimg="xplore.gif";    //水印图片  
    $imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
    $imgpreviewsize=1/2;    //缩略图比例 
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))  
    //是否存在文件  
    {  
    	echo "图片不存在!";  
    	exit;  
    }
    $file = $_FILES["upfile"];
    if($max_file_size < $file["size"])
    //检查文件大小  
    {
    	echo "文件太大!";
    	exit;
    }
    if(!in_array($file["type"], $uptypes))  
    //检查文件类型
    {
    	echo "文件类型不符!".$file["type"];
    	exit;
    }
    if(!file_exists($destination_folder))
    {
    	mkdir($destination_folder);
    }  
    $filename=$file["tmp_name"];  
    $image_size = getimagesize($filename);  
    $pinfo=pathinfo($file["name"]);  
    $ftype=$pinfo['extension'];  
    $destination = $destination_folder.str_shuffle(time().rand(111111,999999)).".".$ftype;  
    if (file_exists($destination) && $overwrite != true)  
    {  
    	echo "同名文件已经存在了";  
    	exit;  
    }  
    if(!move_uploaded_file ($filename, $destination))  
    {  
    	echo "移动文件出错";  
    	exit;
    }
    $pinfo=pathinfo($destination);  
    $fname=$pinfo['basename'];  
    // echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";  
    // echo " 宽度:".$image_size[0];  
    // echo " 长度:".$image_size[1];  
    // echo "<br> 大小:".$file["size"]." bytes";  
    if($watermark==1)  
    {  
    	$iinfo=getimagesize($destination,$iinfo);  
    	$nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
    	$white=imagecolorallocate($nimage,255,255,255);
    	$black=imagecolorallocate($nimage,0,0,0);
    	$red=imagecolorallocate($nimage,255,0,0);
    	imagefill($nimage,0,0,$white);
    	switch ($iinfo[2])
    	{  
    		case 1:
    		$simage =imagecreatefromgif($destination);
    		break;
    		case 2:
    		$simage =imagecreatefromjpeg($destination);
    		break;
    		case 3:
    		$simage =imagecreatefrompng($destination);
    		break;
    		case 6:
    		$simage =imagecreatefromwbmp($destination);
    		break;
    		default:
    		die("不支持的文件类型");
    		exit;
    	}
    	imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
    	imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);
    	switch($watertype)  
    	{
            case 1:   //加水印字符串
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
            break;
            case 2:   //加水印图片
            $simage1 =imagecreatefromgif("xplore.gif");
            imagecopy($nimage,$simage1,0,0,0,0,85,15);
            imagedestroy($simage1);
            break;
        }
        switch ($iinfo[2])
        {
        	case 1:
            //imagegif($nimage, $destination);
        	imagejpeg($nimage, $destination);
        	break;
        	case 2:
        	imagejpeg($nimage, $destination);
        	break;
        	case 3:
        	imagepng($nimage, $destination);
        	break;
        	case 6:
        	imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);
        	break;
        }
        //覆盖原上传文件
        imagedestroy($nimage);
        imagedestroy($simage);
    }
    // if($imgpreview==1)  
    // {  
    // echo "<br>图片预览:<br>";  
    // echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);  
    // echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";  
    // } 
    echo $fname;
    @require_once (IA_ROOT . '/framework/function/file.func.php');
    @$filename=$fname;
    @file_remote_upload($filename); 
}
/////////////////////////////////////////





public function doPageNav(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_nav',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
	echo  json_encode($res);
}
public function doPageTopNav(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_topnav',array('uniacid'=>$_W['uniacid'],'status'=>1),array(),'','orderby asc');
	echo  json_encode($res);
}

public function doPageVipSet(){
	global $_W, $_GPC;
	$res=pdo_getall('zhvip_vipset',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
	echo  json_encode($res);
}


public function doPageIsDq(){
	global $_W, $_GPC;
	$res=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
	if($res['vip_time']<=time()){//到期
		echo '1';
	}else{
		echo '2';
	}

}


//次卡列表
public function doPageNumCardList(){
	global $_W, $_GPC;
	$time=strtotime(date('Y-m-d'));
	$sql="select * from " . tablename("zhvip_numcard") ." WHERE uniacid=".$_W['uniacid']." and  UNIX_TIMESTAMP(time)>=".$time." order by num asc";
	$res=pdo_fetchall($sql);
	echo  json_encode($res);
}
//次卡详情
public function doPageNumCardInfo(){
	global $_W, $_GPC;
	$res=pdo_get('zhvip_numcard',array('id'=>$_GPC['card_id']));
	$store=pdo_get('zhvip_store',array('id'=>$res['store_id']));
	if($store['name']){
	$res['store_name']=$store['name'];	
}else{
	$res['store_name']='全平台使用';
}
	
	echo  json_encode($res);
}
//我的次卡详情
public function doPageMyCardInfo(){
	global $_W, $_GPC;
$sql="select a.*,b.name,b.img,b.time,b.details from " . tablename("zhvip_mynumcard") . " a"  . " left join " . tablename("zhvip_numcard") . " b on b.id=a.card_id where a.id=".$_GPC['id']." order by a.id DESC";
	$res=pdo_fetch($sql);

	function  getCoade($storeid){
    function getaccess_token(){
      global $_W, $_GPC;
      $res=pdo_get('zhvip_system',array('uniacid' => $_W['uniacid']));
      $appid=$res['appid'];
      $secret=$res['appsecret'];
              // print_r($res);die;
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
    function set_msg($storeid){
     $access_token = getaccess_token();
     $data2=array(
      "scene"=>$storeid,
      "page"=>"zh_vip/pages/my/wdck/hx",
      "width"=>400
      );
     $data2 = json_encode($data2);
     $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     curl_setopt($ch, CURLOPT_POST,1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
     $data = curl_exec($ch);
     curl_close($ch);
     return $data;
   }
   $img=set_msg($storeid);
   $img=base64_encode($img);
   return $img;
 }
 $store=pdo_get('zhvip_store',array('id'=>$res['store_id']));
 if($store['name']){
	$res['store_name']=$store['name'];	
}else{
	$res['store_name']='全平台使用';
}
$res['hx_code']=getCoade($_GPC['id']);
echo  json_encode($res);
}
//我的次卡
public function doPageMyCardList(){
	global $_W, $_GPC;
	$time=strtotime(date('Y-m-d'));
	$where="where a.user_id=".$_GPC['user_id'];
	if($_GPC['yxq']=='未失效'){//未失效
		$where .=" and a.number>0 and UNIX_TIMESTAMP(b.time)>=".$time;
	}elseif($_GPC['yxq']=='已失效'){//已失效
		$where .=" and (a.number<=0 || UNIX_TIMESTAMP(b.time)<".$time.")";
	}
	if($_GPC['type']=='次卡'){
		$where .=" and a.type=1 ";
	}
	$sql="select a.*,b.name,b.img,b.time from " . tablename("zhvip_mynumcard") . " a"  . " left join " . tablename("zhvip_numcard") . " b on b.id=a.card_id ".$where." order by a.id DESC";
	$res=pdo_fetchall($sql);
	for($i=0;$i<count($res);$i++){
		if(strtotime($res[$i]['time'])<$time || $res[$i]['number']<=0){
			$res[$i]['is_sx']=1;
		}else{
			$res[$i]['is_sx']=2;
		}
	}
	echo  json_encode($res);
}
//购买次卡
public function doPagePayNumCard(){
	global $_W, $_GPC;
	$data['user_id']=$_GPC['user_id'];
	$data['time']=date("Y-m-d H:i:s");
	$data['form_id']=$_GPC['form_id'];
	$data['card_id']=$_GPC['card_id'];
	$data['uniacid']=$_W['uniacid'];
	$data['money']=$_GPC['money'];
	$data['pay_type']=$_GPC['pay_type'];
	if($_GPC['money']==0){
		$data['state']=2;
	}else{
		$data['state']=1;
	}
	if($_GPC['pay_type']==2 and $_GPC['money']!=0){//余额支付
		$data2['money']=$_GPC['money'];
		$data2['user_id']=$_GPC['user_id'];
		$data2['store_id']=$_GPC['store_id'];
		$data2['type']=2;
		$data2['note']='次卡消费';
		$data2['time']=date('Y-m-d H:i:s');
		$data2['uniacid']=$_W['uniacid'];//小程序id
		pdo_insert('zhvip_qbmx',$data2);
			$qbid=pdo_insertid();
	file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=".$qbid);//模板消息
		pdo_update('zhvip_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));//减余额
	}
	if($_GPC['pay_type']==3 and $_GPC['money']!=0){//积分支付
		$data2['score']=$_GPC['jf'];
		$data2['user_id']=$_GPC['user_id'];
		$data2['note']='次卡消费';
		$data2['type']=2;
		$data2['cerated_time']=date('Y-m-d H:i:s');
		$data2['uniacid']=$_W['uniacid'];//小程序id
		pdo_insert('zhvip_jfmx',$data2);
		pdo_update('zhvip_user',array('integral -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));//减余额
	}
	$res=pdo_insert('zhvip_numcardorder',$data);
	$id=pdo_insertid();
	if($res){
		if($_GPC['pay_type']!=1 and $_GPC['money']>0){
		file_get_contents("".$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=Sj&m=zh_vip&user_id=".$_GPC['user_id']."&money=".$_GPC['money']);//升级
		}
		if($_GPC['pay_type']!=1){
			$card=pdo_get('zhvip_numcard',array('id'=>$_GPC['card_id']));
			$data3['user_id']=$_GPC['user_id'];
			$data3['card_id']=$_GPC['card_id'];
			$data3['money']=$_GPC['money'];
			$data3['type']=$card['type'];
			$data3['number']=$card['number'];
			$data3['uniacid']=$_W['uniacid'];
			$data3['lq_time']=date("Y-m-d H:i:s");
			pdo_insert('zhvip_mynumcard',$data3);	
		}
		
		echo $id;
	}else{
		echo '下单失败';
	}

}
//核销
public function doPageHxCard(){
	global $_W, $_GPC;
	$sql2="select a.*,b.name,b.img,b.time from " . tablename("zhvip_mynumcard") . " a"  . " left join " . tablename("zhvip_numcard") . " b on b.id=a.card_id where a.id=".$_GPC['id']." order by a.id DESC";
	$res=pdo_fetch($sql2);

	if($res['number']<=0 || strtotime($res['time'])<strtotime(date("Y-m-d H:i:s"))){
		echo  '卡已失效!';	
	}else{
		$sql="select * from " . tablename("zhvip_numcard") ." where id=".$res['card_id']." and  (find_in_set('{$_GPC['store_id']}',store_id) || store_id=0)";
		$card=pdo_fetch($sql);

		if($card){
			$hx=pdo_update('zhvip_mynumcard',array('number -='=>1),array('id'=>$_GPC['id']));
			if($hx){
				$data['user_id']=$res['user_id'];
				$data['card_id']=$res['card_id'];
				$data['hx_id']=$_GPC['hx_id'];
				$data['num']=1;
				$data['time']=date('Y-m-d H:i:s');
				$data['uniacid']=$_W['uniacid'];
				pdo_insert('zhvip_numcard_record',$data);
				file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=kcMessage&m=zh_vip&id=".$_GPC['id']);//模板消息
				echo '核销成功!';
			}else{
				echo '核销失败!';
			}
			
		}else{
			echo  '暂无核销权限!';
		}
	}
}
//记录
public function doPageRecord(){
	global $_W, $_GPC;
	$sql="select a.*,c.username,d.name as store_name from " . tablename("zhvip_numcard_record") . " a"  . " left join " . tablename("zhvip_admin") . " b on b.id=a.hx_id left join " . tablename("users") . " c on c.uid=b.uid left join " . tablename("zhvip_store") . " d on d.id=b.storeid where a.user_id=".$_GPC['user_id']." and a.card_id = ".$_GPC['card_id']." order by a.id DESC";
	$res=pdo_fetchall($sql);
	echo  json_encode($res);
}
//商城轮播图
public function doPageStoreAd(){
	global $_W, $_GPC;
	$list=pdo_getall('zhvip_storead',array('uniacid'=>$_W['uniacid'],'status'=>1,'store_id'=>$_GPC['store_id']),array(),'','orderby asc');
	echo json_encode($list);
}



public function dopageSj(){
	global $_W, $_GPC;
	pdo_update('zhvip_user',array('cumulative +='=>$_GPC['money'],'level_cumulative +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
		$user=pdo_get('zhvip_user',array('id'=>$_GPC['user_id']));
		$dj=pdo_get('zhvip_level',array('id'=>$user['grade']));
		$level=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid'],'level >'=>$dj['level']),array(),'','level asc');
		if($level){
			$money=$user['level_cumulative'];
			for($i=0;$i<count($level);$i++){
				if(($money-$level[$i]['threshold'])>=0){
					$money=$money-$level[$i]['threshold'];
					pdo_update('zhvip_user',array('grade'=>$level[$i]['id'],'level_cumulative'=>$money),array('id'=>$_GPC['user_id'])); 
					file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=SjMessage&m=zh_vip&user_id=".$_GPC['user_id']."&level=".$level[$i]['id']);//模板消息
				}else{
					break;
				}
			}
		}
}


//添加formid
public function doPageAddFormId(){
	global $_W, $_GPC;
	if($_GPC['form_id']!="the formId is a mock one" and $_GPC['form_id']){
		$data['user_id']=$_GPC['user_id'];
		$data['form_id']=$_GPC['form_id'];
		$data['uniacid']=$_W['uniacid'];
		$data['time']=time();
		$res=pdo_insert('zhvip_formid',$data);
	}
}




//升级发送模板消息
public function doPageSjMessage(){
	global $_W, $_GPC;
	 pdo_delete('zhvip_formid',array('time <='=>time()-60*60*24*7));
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
		$form=pdo_get('zhvip_formid',array('user_id'=>$_GET['user_id'],'time >='=>time()-60*60*24*7),array(),'','id asc');
		$user=pdo_get('zhvip_user',array('id'=>$_GET['user_id']));
		$level=pdo_get('zhvip_level',array('id'=>$_GET['level']));
		$formwork ='{
			"touser": "'.$user["openid"].'",
			"template_id": "'.$res["sj_tid"].'",
			"page": "zh_vip/pages/index/index",
			"form_id":"'.$form['form_id'].'",
			"data": {
				"keyword1": {
					"value": "会员升级成功",
					"color": "#173177"
				},
				"keyword2": {
					"value":"'.date("Y-m-d H:i:s").'",
					"color": "#173177"
				},
				"keyword3": {
					"value": "'.$user['vip_code'].'",
					"color": "#173177"
				},
				"keyword4": {
					"value": "'.$level['name'].'",
					"color": "#173177"
				},
				"keyword5": {
					"value": "'.$user['wallet'].'",
					"color": "#173177"
				}
			},
			"emphasis_keyword": "keyword1.DATA" 
		}';
			 // $formwork=$data;
		$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
		$data = curl_exec($ch);
		curl_close($ch);
		// return $data;
		pdo_delete('zhvip_formid',array('id'=>$form['id']));
	}
	echo set_msg($_W);
}






//次卡核销通知
public function doPageKcMessage(){
	global $_W, $_GPC;
	 pdo_delete('zhvip_formid',array('time <='=>time()-60*60*24*7));
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
		$mycard=pdo_get('zhvip_mynumcard',array('id'=>$_GET['id']));//我的次卡
		$numcard=pdo_get('zhvip_numcard',array('id'=>$mycard['card_id']));//次卡
		$store=pdo_get('zhvip_store',array('id'=>$numcard['store_id']));//商家
		if($store){
			$store_name=$store['name'];
		}else{
			$store_name='全平台';
		}
		$form=pdo_get('zhvip_formid',array('user_id'=>$mycard['user_id'],'time >='=>time()-60*60*24*7),array(),'','id asc');
		$user=pdo_get('zhvip_user',array('id'=>$mycard['user_id']));
		$formwork = [
                'touser' => $user["openid"],
                'template_id' => $res["kc_tid"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'thing5' => [
                        'value' => "次卡扣次成功",
                        'color' => '#173177',
                    ],
                    'thing1' => [
                        'value' => $store_name,
                        'color' => '#173177',
                    ],
                     'time4' => [
                        'value' => date("Y-m-d H:i:s"),
                        'color' => '#173177',
                    ],
                    'number3' => [
                        'value' => $mycard['number'],
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
		// return $data;
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["kc_tid"]));
	}
	echo set_msg($_W);
}



//余额变更通知
public function doPageYueMessage(){
	global $_W, $_GPC;
	 pdo_delete('zhvip_formid',array('time <='=>time()-60*60*24*7));
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
		$qbmx=pdo_get('zhvip_qbmx',array('id'=>$_GET['id']));//我的钱包明细
		$store=pdo_get('zhvip_store',array('id'=>$qbmx['store_id']));//商家
		if($store){
			$store_name=$store['name'];
		}else{
			$store_name='平台';
		}
		if($qbmx['type']==1){
			$money="+".$qbmx['money'];
		}else{
			$money="-".$qbmx['money'];
		}
		$form=pdo_get('zhvip_formid',array('user_id'=>$qbmx['user_id'],'time >='=>time()-60*60*24*7),array(),'','id asc');
		$user=pdo_get('zhvip_user',array('id'=>$qbmx['user_id']));
		$formwork = [
                'touser' => $user["openid"],
                'template_id' => $res["yue_tid"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'thing5' => [
                        'value' => "您的余额有变动",
                        'color' => '#173177',
                    ],
                    'thing4' => [
                        'value' => $qbmx['note'],
                        'color' => '#173177',
                    ],
                     'amount2' => [
                        'value' => $user['wallet'],
                        'color' => '#173177',
                    ],
                    'character_string1' => [
                        'value' => $money,
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
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["yue_tid"]));
		//$data1['content']=json_encode($data);
		//$res=pdo_insert('zhvip_error',$data1);
		//pdo_delete('zhvip_formid',array('id'=>$form['id']));
	}
	echo set_msg($_W);
}




//积分兑换成功通知
public function doPageJfMessage(){
	global $_W, $_GPC;
	 pdo_delete('zhvip_formid',array('time <='=>time()-60*60*24*7));
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
		$record=pdo_get('zhvip_jfrecord',array('id'=>$_GET['id']));//我的积分兑换记录
		$good=pdo_get('zhvip_jfgoods',array('id'=>$record['good_id']));//商品信息
		$form=pdo_get('zhvip_formid',array('user_id'=>$record['user_id'],'time >='=>time()-60*60*24*7),array(),'','id asc');
		$user=pdo_get('zhvip_user',array('id'=>$record['user_id']));
			$formwork = [
                'touser' => $user["openid"],
                'template_id' => $res["jf_tid"],
                'page'=>"zh_vip/pages/index/index",
                'data' => [
                    'thing6' => [
                        'value' => $good['name'],
                        'color' => '#173177',
                    ],
                    'number2' => [
                        'value' => $record['integral'],
                        'color' => '#173177',
                    ],
                     'date4' => [
                        'value' => $record['time'],
                        'color' => '#173177',
                    ],
                    'number3' => [
                        'value' => $user['integral'],
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
		pdo_delete('zhvip_dingyue',array('user_id'=>$user["id"],'tpl_id'=>$res["jf_tid"]));
	}
	echo set_msg($_W);
}



//商家的次卡
public function doPageStoreCardList(){
	global $_W, $_GPC;
	$time=strtotime(date('Y-m-d'));
	$where=" where (store_id={$_GPC['store_id']} or store_id=0 )";
	if($_GPC['yxq']=='未失效'){//未失效
		$where .="  and UNIX_TIMESTAMP(time)>=".$time;
	}elseif($_GPC['yxq']=='已失效'){//已失效
		$where .=" and  UNIX_TIMESTAMP(time)<".$time;
	}
	if($_GPC['type']=='次卡'){
		$where .=" and type=1 ";
	}
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=empty($_GPC['pagesize'])?10:$_GPC['pagesize'];
	$sql="select * from " . tablename("zhvip_numcard") .$where." order by id DESC";
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$res = pdo_fetchall($select_sql,$data);
	for($i=0;$i<count($res);$i++){
		if(strtotime($res[$i]['time'])<$time || $res[$i]['number']<=0){
			$res[$i]['is_sx']=1;
		}else{
			$res[$i]['is_sx']=2;
		}
	}
	echo  json_encode($res);
}


//卡的核销记录
public function doPageCardRecord(){
	global $_W, $_GPC;
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=empty($_GPC['pagesize'])?10:$_GPC['pagesize'];
	$sql="select a.*,c.username,d.name as store_name,e.nickname,e.img from " . tablename("zhvip_numcard_record") . " a"  . " left join " . tablename("zhvip_admin") . " b on b.id=a.hx_id left join " . tablename("users") . " c on c.uid=b.uid left join " . tablename("zhvip_store") . " d on d.id=b.storeid  left join " . tablename("zhvip_user") . " e on e.id=a.user_id where a.card_id =:card_id order by a.id DESC";
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$res = pdo_fetchall($select_sql,array(':card_id'=>$_GPC['card_id']));
	echo  json_encode($res);
}



    //商家微信登录
        public function doPageStoreWxLogin()
        {
            global $_GPC, $_W;
            $res = pdo_get('zhvip_store', array('admin_id' => $_GPC['user_id']));
            if ($res) {
            	return  json_encode(array('msg'=>$res,'code'=>1),320);exit();
           
            } else {
               return json_encode(array('msg'=>'您还不是该店铺管理员','code'=>0),320);exit();
            }
        }

    
    
    public function doPageDlist(){
 
    	global $_GPC, $_W;
		$info = pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
		$model['tid'] =$info['tid'];
		$model['tid2'] = $info['tid2'];
		$model['tid3'] = $info['tid3'];
		$model['tid4'] =$info['tid4'];
		$model['kc_tid'] =$info['kc_tid'];
		$model['yue_tid'] =$info['yue_tid'];
		$model['jf_tid'] =$info['jf_tid'];

		$arr = ['tid' => '客户买单通知', 'tid2' => '客户开卡通知', 'tid3' => '客户充值通知', 'tid4' => '发货通知', 'kc_tid' => '次卡扣次通知', 'yue_tid' => '用户余额变更通知', 'jf_tid' => '积分兑换成功通知'];
		$new_list = [];
		foreach ($model as $k => $val) {
		$new_arr['title'] = $arr[$k];
		$new_arr['tpl_name'] = $k;
		$new_arr['tpl_id'] = $val;
		$new_list[] = $new_arr;
		}
		foreach ($new_list as $key => $value) {
            $new_list[$key]['rec'] = pdo_get('zhvip_dingyue',array('uniacid'=>$_W['uniacid'],'user_id'=>$_GPC['user_id'],'tpl_id'=>$value['tpl_id'],'tpl_name'=>$value['tpl_name']));
              if ($new_list[$key]['rec']) {
              $new_list[$key]['is_dy'] = 1;
              } 
              
        }
		echo  json_encode($new_list);

    }
    
    public function doPageSubscribe(){ 
    	global $_GPC, $_W;
        $detail=array(
            'uniacid'=>$_W['uniacid'],
            'addtime'=>time(),
            'user_id'=>$_GPC['user_id'],
            'state'=>1,
            'tpl_id'=>$_GPC['tpl_id'],
            'tpl_name'=>$_GPC['tpl_name'],
            
        );
       // echo "<pre>";print_r($detail);die;
         $res=pdo_insert('zhvip_dingyue',$detail);
         success_withimg_json($res);
    }








////////////////////////////
}////////////////