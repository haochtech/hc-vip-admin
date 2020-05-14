    <?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhvip_topnav',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
         $data['logo']=$_GPC['logo'];
        $data['src']=$_GPC['src'];
        $data['orderby']=$_GPC['orderby'];
        $data['status']=$_GPC['status'];
        $data['title']=$_GPC['title'];
         $data['src2']=$_GPC['src2'];
         $data['item']=$_GPC['item'];
        $data['xcx_name']=$_GPC['xcx_name'];
        $data['appid']=trim($_GPC['appid']);
        $data['uniacid']=$_W['uniacid'];
     if($_GPC['id']==''){  
        $res=pdo_insert('zhvip_topnav',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('topnav'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhvip_topnav',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('topnav'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addtopnav');