<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$stores = pdo_fetchall("SELECT * FROM " . tablename('zhvip_store') . " WHERE uniacid= :weid and type=1 ORDER BY id DESC", array(':weid' => $_W['uniacid']), 'id');
    $id = intval($_GPC['id']);
    //echo $id;die;
    $storeid = intval($_GPC['storeid']);
    if (!empty($id)) {
        $account = pdo_fetch("SELECT * FROM " . tablename('zhvip_admin') . " WHERE weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $_W['uniacid'], ':id' => $id));
        //$fans = $this->getFansByOpenid($account['from_user']);
     //   print_r($account);die;
    }
    if (!empty($account)) {
        $users = user_single($account['uid']);
    }
 if (checksubmit('submit')) {
        load()->model('user');
        $user = array();
        $user['username'] = trim($_GPC['username']);
        if (!preg_match(REGULAR_USERNAME, $user['username'])) {
            message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
        }
        if (empty($users)) {
            $user['password'] = $_GPC['password'];
            if (istrlen($user['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }
        if (!empty($_GPC['password'])) {
            $user['password'] = $_GPC['password'];
            if (istrlen($user['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }
        if (!empty($account)) {
            $user['salt'] = $users['salt'];
            $user['uid'] = $account['uid'];
        }
        $user['remark'] = $_GPC['remark'];
        $user['status'] = $_GPC['status'];
//            $user['groupid'] = intval($_GPC['groupid']) ? intval($_GPC['groupid']) : message('请选择所属用户组');
        $user['groupid'] = -1;
        if (empty($users)) {
            if (user_check(array('username' => $user['username']))) {
                message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
            }
            $uid = user_register($user,$source='');
            if ($uid > 0) {
                unset($user['password']);
                //operator
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'uid' => $uid,
                    'role' => 'operator',
                );
                $exists = pdo_fetch("SELECT * FROM " . tablename('uni_account_users') . " WHERE uid = :uid AND uniacid = :uniacid", array(':uniacid' => $_W['uniacid'], ':uid' => $uid));
                if (empty($exists)) {
                    pdo_insert('uni_account_users', $data);
                }
                //permission
                pdo_insert('users_permission', array(
                    'uid' => $uid,
                    'uniacid' => $_W['uniacid'],
                    'url' => '',
                    'type' => 'zh_vip',
                    'permission' => 'zh_vip_menu_store'
                ));
//update ims_users_permission set permission='zh_dianc_menu_stores2' where permission='zh_dianc_menu_stores';
                pdo_insert('zhvip_admin', array(
                    'uid' => $uid,
                    'weid' => $_W['uniacid'],
                    'storeid' => intval($_GPC['storeid']),
                    'from_user' => trim($_GPC['from_user']),
                    'email' => trim($_GPC['email']),
                    'mobile' => trim($_GPC['mobile']),
                    'pay_account' => trim($_GPC['pay_account']),
                    'status' => intval($_GPC['status']),
                    'remark' => trim($_GPC['remark']),
                    'dateline' => TIMESTAMP,
                    'username' => trim($_GPC['truename']),
                    'role' => 1,
                    'is_admin_order' => intval($_GPC['is_admin_order']),
                    'is_notice_order' => intval($_GPC['is_notice_order']),
                    'is_notice_service' => intval($_GPC['is_notice_service']),
                    'is_notice_boss' => intval($_GPC['is_notice_boss']),
                    'is_notice_queue' => intval($_GPC['is_notice_queue']),
                ));
                message('用户增加成功！!', $this->createWebUrl('account', array(), true));
            }
        }else {
            $_GPC['password'] = safe_gpc_string($_GPC['password']);
            $check_safe = safe_check_password($_GPC['password']);
            if (is_error($check_safe)) {
                message($check_safe['message'],'');
            }
            $newpwd = user_password($_GPC['password'], $account['uid']);
          
            pdo_update('users', array('password' => $newpwd,'username' => $_GPC['username']), array('uid' => $account['uid']));
            pdo_update('zhvip_admin', array(
                'weid' => $_W['uniacid'],
                'storeid' => intval($_GPC['storeid']),
                'from_user' => trim($_GPC['from_user']),
                'email' => trim($_GPC['email']),
                'mobile' => trim($_GPC['mobile']),
                'pay_account' => trim($_GPC['pay_account']),
                'status' => intval($_GPC['status']),
                'remark' => trim($_GPC['remark']),
                'dateline' => TIMESTAMP,
                'role' => 1,
                'username' => trim($_GPC['truename']),
                'is_admin_order' => intval($_GPC['is_admin_order']),
                'is_notice_order' => intval($_GPC['is_notice_order']),
                'is_notice_service' => intval($_GPC['is_notice_service']),
                'is_notice_boss' => intval($_GPC['is_notice_boss']),
                'is_notice_queue' => intval($_GPC['is_notice_queue']),
            ), array('id' => $id));
            message('更新成功！', $this->createWebUrl('account', array(), true));
        }
        message('操作用户失败，请稍候重试或联系网站管理员解决！');
   }
include $this->template('web/countadd');