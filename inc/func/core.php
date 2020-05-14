<?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
   


    public function getMainMenu()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if ($_W['role'] == 'operator') {
                $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=store&m=zh_vip" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>门店管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('门店管理 ', $do, 'store', ''),
                    
                )
            );
        }elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator'){
             $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=index&m=zh_vip" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>门店管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据概况 ', $do, 'index', ''),
                     1 => $this->createMainMenu('门店管理 ', $do, 'store', ''),
                     2 => $this->createMainMenu('门店账号 ', $do, 'account', ''),
                    // 3 => $this->createMainMenu('小程序端账号管理 ', $do, 'admin', ''),
                     4 => $this->createMainMenu('广告门店管理 ', $do, 'storead', ''),
                )
            );
            $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=user&m=zh_vip" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>会员管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('会员管理', $do, 'user', ''),
                    1 => $this->createMainMenu('用户管理', $do, 'user2', ''),
                    2 => $this->createMainMenu('等级管理 ', $do, 'level', ''),
                    3=> $this->createMainMenu('开卡设置 ', $do, 'opencard', ''),
                    4=> $this->createMainMenu('期限管理 ', $do, 'vipset', ''),
                    5=> $this->createMainMenu('开卡记录 ', $do, 'viprecord', ''),
                     6=> $this->createMainMenu('会员订单 ', $do, 'userorder', ''),
                )
            );
            $navemenu[10] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=numcard&m=zh_vip" class="panel-title wytitle" id="yframe-10"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>次卡管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('次卡管理', $do, 'numcard', ''),
                    1 => $this->createMainMenu('次卡设置', $do, 'ckset', ''),
                )
            );
            $navemenu[11] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=stcard&m=zh_vip" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d; margin-right:14px;" class="fa fa-user"></icon>实体卡管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('实体卡管理', $do, 'stcard', ''),
                )
            );
            $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=order&m=zh_vip" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-file-text-o"></icon>订单管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('订单管理 ', $do, 'order', ''),
                )
            );
            
            $navemenu[4] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=coupons&m=zh_vip" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>   优惠券管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('优惠券管理 ', $do, 'coupons', ''),
                )
            );
            $navemenu[9] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=nav&m=zh_vip" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>   导航管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('导航管理 ', $do, 'nav', ''),
                     1 => $this->createMainMenu('顶部导航管理 ', $do, 'topnav', ''),
                )
            );
            // 下面是复制的上面的数据
            $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=ad&m=zh_vip" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>广告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('广告管理 ', $do, 'ad', ''),
                )
            );
             $navemenu[8] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=jfgoods&m=zh_vip" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>积分商城</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表', $do, 'jfgoods', ''),
                    1 => $this->createMainMenu('商品分类', $do, 'jftype', ''),
                    2 => $this->createMainMenu('积分设置', $do, 'jfsz', ''),
                )
            );
          // $navemenu[3] = array(
          //       'title' => '<icon style="color:#8d8d8d;" class="fa fa-money"></icon>提现管理',
          //       'items' => array(
          //            0 => $this->createMainMenu('提现列表 ', $do, 'txlist', ''),
          //            1 => $this->createMainMenu('提现设置 ', $do, 'txsz', ''),
          //       )
          //   );
           $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=chongzhi&m=zh_vip" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-recycle"></icon>财务管理</a>',
                'items' => array(
                    2 => $this->createMainMenu('充值优惠', $do, 'chongzhi', ''),
                   3 => $this->createMainMenu('充值记录', $do, 'czjl', '')
                )
            );
            $navemenu[16] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=xsdata&m=zh_vip" class="panel-title wytitle" id="yframe-16"><icon style="color:#8d8d8d;" class="fa fa-key"></icon>  数据统计</a>',
                'items' => array(
                    1 => $this->createMainMenu('销售额统计 ', $do, 'xsdata', ''),
                )
            );
            $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=settings&m=zh_vip" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>系统设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
                    1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
                    2 => $this->createMainMenu('支付配置', $do, 'pay', ''), 
                    3 => $this->createMainMenu('短信配置', $do, 'sms', ''),
                    4 => $this->createMainMenu('模板消息配置', $do, 'template', ''), 
                    5 => $this->createMainMenu('帮助中心', $do, 'help', ''),  
                    6 => $this->createMainMenu('版权设置', $do, 'bqset', ''),                
                )
            );
        }
    
        return $navemenu;
    }
   public function getMainMenu2()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        $navemenu[0] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=indexinfo&m=zh_vip" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>数据概况</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据概况', $do, 'indexinfo', ''),
                )
            );
        $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=inuser&m=zh_vip" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>会员管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('会员管理 ', $do, 'inuser', ''),
                )
            );
         $sc=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
         if($sc['is_sc']==1){
         $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=goods&m=zh_vip" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>商城管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品管理 ', $do, 'goods', ''),
                     1 => $this->createMainMenu('分类管理 ', $do, 'fenlei', ''),
                     2 => $this->createMainMenu('订单管理 ', $do, 'mallorder', ''),
                     3 => $this->createMainMenu('评论管理 ', $do, 'assess', ''),
                     4 => $this->createMainMenu('商城设置 ', $do, 'mallset', ''),
                     5 => $this->createMainMenu('广告管理 ', $do, 'storead2', ''),
                )
            );
     }
        $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&do=inorder&m=zh_vip" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-file-text-o"></icon>订单管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('订单管理 ', $do, 'inorder', ''),
                )
            );
        $navemenu[6] = array(
            'title' => '<a href="index.php?c=site&a=entry&do=inczjl&m=zh_vip" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-recycle"></icon>财务管理</a>',
            'items' => array(
               0 => $this->createMainMenu('充值记录', $do, 'inczjl', '')
            )
        );
        $navemenu[7] = array(
            'title' => '<a href="index.php?c=site&a=entry&do=print&m=zh_vip" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-clipboard"></icon>打印设置</a>',
            'items' => array(
               0 => $this->createMainMenu('打印机管理', $do, 'print', '')
            )
        );
        $navemenu[8] = array(
            'title' => '<a href="index.php?c=site&a=entry&do=insms&m=zh_vip" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-clipboard"></icon>短信设置</a>',
            'items' => array(
               0 => $this->createMainMenu('短信设置', $do, 'insms', '')
            )
        );
        return $navemenu;
    }



       public function getNaveMenu($storeid='', $action='')
    {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = '#8d8d8d';
        // $navemenu[0] = array(
        //     'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=start&m=zh_dianc" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>门店设置</a>',
        //     'items' => array(
        //         0 => $this->createSubMenu('数据概况', $do, 'start', 'fa-angle-right', $cur_color, $storeid),
        //         1 => $this->createSubMenu('门店信息 ', $do, 'dlstoreinfo', 'fa-angle-right', $cur_color, $storeid),
        //         2 => $this->createSubMenu('营业时间 ', $do, 'dlyingyetime', 'fa-angle-right', $cur_color, $storeid),
        //         3 => $this->createSubMenu('配送设置 ', $do, 'dlpeisongset', 'fa-angle-right', $cur_color, $storeid),
        //         4 => $this->createSubMenu('积分设置 ', $do, 'dlinjfset','fa-angle-right', $cur_color, $storeid),
        //         5 => $this->createSubMenu('支付设置', $do, 'dlinpay', 'fa-angle-right', $cur_color, $storeid),
        //     ),
        //     'icon' => 'fa fa-user-md'
        // );
         $navemenu[0] = array(
                'title' => '<a href="zhvip.php?c=site&a=entry&do=dlindexinfo&m=zh_vip" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>数据概况</a>',
                'items' => array(
                     0 => $this->createSubMenu('数据概况 ', $do, 'dlindexinfo', 'fa-angle-right', $cur_color, $storeid),
                )
            );
     	 $navemenu[1] = array(
                'title' => '<a href="zhvip.php?c=site&a=entry&do=dlinuser&m=zh_vip" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>会员管理</a>',
                'items' => array(
                     0 => $this->createSubMenu('会员管理 ', $do, 'dlinuser', 'fa-angle-right', $cur_color, $storeid),
                )
            );
         $sc=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
         if($sc['is_sc']==1){
          $navemenu[3] = array(
                'title' => '<a href="zhvip.php?c=site&a=entry&do=dlgoods&m=zh_vip" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>商城管理</a>',
                'items' => array(
                     0 => $this->createSubMenu('商品管理 ', $do, 'dlgoods', 'fa-angle-right', $cur_color, $storeid),
                     1 => $this->createSubMenu('分类管理 ', $do, 'dlfenlei', 'fa-angle-right', $cur_color, $storeid),
                     2 => $this->createSubMenu('订单管理 ', $do, 'dlmallorder', 'fa-angle-right', $cur_color, $storeid),
                     3 => $this->createSubMenu('评论管理 ', $do, 'dlassess', 'fa-angle-right', $cur_color, $storeid),
                     4 => $this->createSubMenu('商城设置 ', $do, 'dlmallset', 'fa-angle-right', $cur_color, $storeid),
                     5 => $this->createSubMenu('广告管理 ', $do, 'dlstoread', 'fa-angle-right', $cur_color, $storeid),
                )
            );
          }
        $navemenu[2] = array(
                'title' => '<a href="zhvip.php?c=site&a=entry&do=dlinorder&m=zh_vip" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-file-text-o"></icon>订单管理</a>',
                'items' => array(
                     0 => $this->createSubMenu('订单管理 ', $do, 'dlinorder', 'fa-angle-right', $cur_color, $storeid),
                )
            );
       
        $navemenu[6] = array(
            'title' => '<a href="zhvip.php?c=site&a=entry&do=dlinczjl&m=zh_vip" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-recycle"></icon>财务管理</a>',
            'items' => array(
               0 => $this->createSubMenu('充值记录', $do, 'dlinczjl', 'fa-angle-right', $cur_color, $storeid)
            )
        );
        $navemenu[7] = array(
            'title' => '<a href="zhvip.php?c=site&a=entry&do=dlprint&m=zh_vip" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-clipboard"></icon>打印设置</a>',
            'items' => array(
               0 => $this->createMainMenu('打印机管理', $do, 'dlprint', '')
            )
        );
        $navemenu[8] = array(
            'title' => '<a href="zhvip.php?c=site&a=entry&do=dlinsms&m=zh_vip" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-clipboard"></icon>短信设置</a>',
            'items' => array(
               0 => $this->createMainMenu('短信设置', $do, 'dlinsms', '')
            )
        );
   
        return $navemenu;
    }


        function createWebUrl2($do, $query = array()) {
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);
      
        return $this->wurl('site/entry', $query);
    }

    function wurl($segment, $params = array()) {
      
    list($controller, $action, $do) = explode('/', $segment);
    $url = './zhvip.php?';
    if (!empty($controller)) {
        $url .= "c={$controller}&";
    }
    if (!empty($action)) {
        $url .= "a={$action}&";
    }
    if (!empty($do)) {
        $url .= "do={$do}&";
    }
    if (!empty($params)) {
        $queryString = http_build_query($params, '', '&');
        $url .= $queryString;
    }
    return $url;
}

    function createCoverMenu($title, $method, $op, $icon = "fa-image", $color = '#d9534f')
    {
        global $_GPC, $_W;
        $cur_op = $_GPC['op'];
        $color = ' style="color:'.$color.';" ';
        return array('title' => $title, 'url' => $op != $cur_op ? $this->createWebUrl($method, array('op' => $op)) : '',
            'active' => $op == $cur_op ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa fa-angle-right"></i>',
            )
        );
    }

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {
        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }

    // function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
    // {
    //     $color = ' style="color:'.$color.';" ';
    //     $url = $this->createWebUrl($method, array('op' => 'display', 'storeid' => $storeid));
    //     if ($method == 'stores') {
    //         $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
    //     }

    //     return array('title' => $title, 'url' => $do != $method ? $url : '',
    //         'active' => $do == $method ? ' active' : '',
    //         'append' => array(
    //             'title' => '<i class="fa '.$icon.'"></i>',
    //         )
    //     );
    // }
         function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl2($method, array('op' => 'display', 'storeid' => $storeid));
        if ($method == 'stores2') {
            $url = $this->createWebUrl2('stores2', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
        }



        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
            )
        );
    }

    public function getStoreById($id)
    {
        $store = pdo_fetch("SELECT * FROM " . tablename('zhvip_store') . " WHERE id=:id LIMIT 1", array(':id' => $id));
        return $store;
    }


    public function set_tabbar($action, $storeid)
    {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            if ($key == 'stores') {
                $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid));
            } else {
                $url = $this->createWebUrl($key, array('op' => 'display', 'storeid' => $storeid));
            }

            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
    public   function getSon($pid ,$arr){
        $newarr=array();
        foreach ($arr as $key => $value) {
            if($pid==$value['type_id']){
                $newarr[]=$value; 
               // continue;                     
            }      
        }
        return $newarr;
        
    }

}