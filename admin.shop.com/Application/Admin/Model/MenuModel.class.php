<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/28
 * Time: 17:32
 */

namespace Admin\Model;


use Admin\Logic\MysqlDb;
use Admin\Logic\NestedSets;
use Think\Model;

class MenuModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['menu_name','require','菜单名不能为空！'],
        ['parent_id','number','权限不合法！'],
    ];
    /**
     * 添加菜单
     */
    public function addMenu(){
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
        if(!$menu_id = $nestedests->insert($this->data['parent_id'],$this->data,'bottom')){
            $this->error = '添加父类菜单失败！';
            return false;
        }
        $permission_ids = I('post.permission_id');
//        var_dump($permission_ids);exit;
        if(empty($permission_ids)){
            return true;
        }
        $data =[];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'menu_id' => $menu_id,
                'permission_id' => $permission_id,
            ];
        }
        if(!M('MenuPermission')->addAll($data)){
            $this->error = '添加权限失败';
            return false;
        }else{
            return true;
        }
    }
    /**
     * 编辑菜单
     */
    public function saveMenu(){
        //修改菜单父类
        $id = I('post.id');
        $old_pid = $this->where(['id' => $id])->getField('parent_id');

        $new_pid = $this->data['parent_id'];
//        var_dump($old_pid,$new_pid);exit;
        if($old_pid != $new_pid){
            $orm = new MysqlDb();
            $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
            if(!$menu_id = $nestedests->moveUnder($this->data['id'],$new_pid,'bottom')){
                $this->error = '编辑父类菜单失败！';
                return false;
            }
        }
        //修改基本资料
        if($this->save() === false){
            $this->error = '编辑资料失败！';
            return false;
        }
        //清除菜单相关的权限 在重新添加
        if(D('MenuPermission')->where(['menu_id'=>$id])->delete() === false){
            $this->error = '编辑资料失败！';
            return false;
        }
        //接收修改权限
        $permission_ids = I('post.permission_id');
        if(empty($permission_ids)){
            return true;
        }
        $data =[];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'menu_id' => $id,
                'permission_id' => $permission_id,
            ];
        }
        //添加权限到关联表
        if(!M('MenuPermission')->addAll($data)){
            $this->error = '编辑权限失败';
            return false;
        }else{
            return true;
        }
    }

    /**
     * 删除菜单
     * @param $id
     */
    public function deleteMenu($id){
//        var_dump($id);exit;
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
        //首先得到对应的数据 及其他的后代
        $children = $nestedests -> getDescendants($id);
//        dump($children);exit;
        $ids = [];
        foreach ($children as $child){
            $ids[] = $child['id'];
        }
        if(M('MenuPermission')->where(['menu_id'=>['in',$ids]])->delete() === false){
            $this->error = '删除菜单相关权限失败！';
            return false;
        }
        //在删除菜单
        if($nestedests->delete($id) === false){
            $this->error = '删除菜单失败！';
            return false;
        }
        return true;
    }
    /**
     * 获取菜单相关的权限
     * @param $id
     * @return mixed
     */
    public function getMenuInfo($id){
//        var_dump($id);exit;
        $row = $this->find($id);
        $permission_ids = D('MenuPermission')->where(['menu_id'=>$id])->getField('permission_id',true);
        $permission_ids = json_encode($permission_ids);
        $row['permission_ids'] = $permission_ids;
        return $row;
    }
    /**
     * 获取菜单
     */
    public function getAdminMenuList(){
        //admin超级管理员可以拥有所有权限
        $admin_username = session('login_info.admin_username');
        if($admin_username == 'admin'){
            $menus = $this->field('id,parent_id,menu_name,path,level')->order('lft')->select();
        }else{
            //其他管理员 只能访问其自身的权限列表
            $permission_ids = array_keys(session('PERMISSIONS'));
            //如果没有权限 则返回空数组
            if(empty($permission_ids)){
                return [];
            }
            //获取权限对应的的菜单 distinct 去重 alias 命别名
            $menus = $this->distinct(true)
                ->field('id,parent_id,menu_name,path,level')
                ->alias('m')
                ->join('menu_permission mp on mp.menu_id = m.id')
                ->where(['permission_id'=>['in',$permission_ids]])
                ->order('lft')
                ->select();
        }
        //当前访问地址
//        $url = MODULE_NAME. '/' .CONTROLLER_NAME . '/' .ACTION_NAME;
//        $parent_id = $this->getFieldByPath($url,'parent_id');
//        $paths = $this->where(['parent_id'=>$parent_id])->select();
////        var_dump($paths);exit;
//        foreach($paths as $key=>$value){
//            $menus['active'] = $value['path'];
//            $menus[$key] = $value;
//        }
//        dump($menus);exit;
        return $menus;
    }
}