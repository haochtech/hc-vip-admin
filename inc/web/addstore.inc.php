<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item = pdo_get('zhvip_store', array('id' => $_GPC['id']));
$userinfo2=pdo_get('zhvip_user',array('id'=>$item['admin_id']));
$storeid = $_GPC['id'];
if (checksubmit('submit')) {
    $data['coordinates'] = $_GPC['coordinates'];
    $data['logo'] = $_GPC['logo'];
    $data['name'] = $_GPC['name'];
    $data['tel'] = $_GPC['tel'];
    $data['cz_img'] = $_GPC['cz_img'];
    $data['address'] = $_GPC['address'];
    $data['announcement'] = $_GPC['announcement'];
    $data['num'] = $_GPC['num'];
    $data['md_img'] = $_GPC['md_img'];
    $data['md_img2'] = $_GPC['md_img2'];
    $data['sentiment'] = $_GPC['sentiment'];
    $data['is_default'] = $_GPC['is_default'];
     $data['admin_id'] = $_GPC['admin_id'];
    $data['uniacid'] = $_W['uniacid'];
    if ($_GPC['id'] == '') {
        $res = pdo_insert('zhvip_store', $data);
        if ($res) {
            message('添加成功！', $this->createWebUrl('store'), 'success');
        } else {
            message('添加失败！', '', 'error');
        }
    } else {
        $res = pdo_update('zhvip_store', $data, array('id' => $_GPC['id']));
        if ($res) {
            message('编辑成功！', $this->createWebUrl('store'), 'success');
        } else {
            message('编辑失败！', '', 'error');
        }
    }

}


function getCoade($storeid)
{
    function getaccess_token()
    {
        global $_W, $_GPC;
        $res = pdo_get('zhvip_system', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $secret = $res['appsecret'];

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data, true);
        return $data['access_token'];
    }

    function set_msg($storeid)
    {
        $access_token = getaccess_token();
        $data2 = array(
            "scene" => $storeid,
            "page" => "zh_vip/pages/index/index",
            "width" => 400
        );
        $data2 = json_encode($data2);
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    $img = set_msg($storeid);
    $img = base64_encode($img);
    return $img;
}

$img = getCoade($storeid);


include $this->template('web/addstore');