<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27
 * Time: 16:17
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class AdminRoleModel extends Model
{
    /**
     * 查询所有角色
     */
    public function getList(){
        //查询当前页面的数据信息
        $lists = $this->order('role_sort')->page(I('get.p', 1), 2)->select();
        $totalCount = $this->count();
        $page = new Page($totalCount,2);
        return [
            'rows'=>$lists,
            'pages'=>$page->show(),
        ];
    }
    /**
     * 添加角色
     */
    public function addRole(){
        //添加角色基本资料
        $role_id = $this->add();
        //添加关联表资料
        $permission_ids = I('post.permission_id');
        if(empty($permission_ids)){
            return true;
        }
//        var_dump($permission_ids);exit;
        //定义一个数组 接收权限id值
        $data = [];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'role_id' => $role_id,
                'permission_id' => $permission_id
            ];
        }
        return M('RolePermission')->addAll($data);
    }
    /**
     * 编辑角色
     */
    public function saveRole($role_id){
        //修改角色基本资料
        $this->save();
        //删除角色相关的所有权限 然后再重新添加
        M('RolePermission')->where(['role_id'=>$role_id])->delete();
        //接收权限id
        $permission_ids = I('post.permission_id');
        if(empty($permission_ids)){
            return true;
        }
        //定义一个数组 接收权限id值
        $data = [];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'role_id' => $role_id,
                'permission_id' => $permission_id
            ];
        }
        return M('RolePermission')->addAll($data);
    }
    /**
     * 获取角色所关联的所有权限
     */
    public function getRoleInfo($id){
        $row = $this->find($id);
        $permission_ids = D('RolePermission')->where(['role_id'=>$id])->getField('permission_id',true);
        $permission_ids = json_encode($permission_ids);
        $row['permission_ids'] = $permission_ids;
//        var_dump($row);exit;
        return $row;
    }
}