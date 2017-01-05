<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27
 * Time: 11:46
 */

namespace Admin\Model;


use Admin\Logic\MysqlDb;
use Admin\Logic\NestedSets;
use Think\Model;

class AdminPermissionModel extends Model
{
    /**
     * 权限列表查询
     */
    public function getList(){
        return $this->order('lft')->select();
    }
    /**
     * 添加权限
     */
    public function addPermission(){
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
        if(!$perId = $nestedests->insert($this->data['parent_id'],$this->data,'bottom')){
            $this->error = '新建权限失败！';
            return false;
        }
        return $perId;
    }
    /**
     * 编辑权限
     */
    public function savePermission($id){
        $old_pid = $this->where(['id'=>$id])->getField('parent_id');
        $new_pid = $this->data['parent_id'];
        if($old_pid != $new_pid){
            $orm = new MysqlDb();
            $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
            if(!$perId = $nestedests->moveUnder($this->data['id'],$this->data['parent_id'],'bottom')){
                $this->error = '编辑父类权限失败！';
                return false;
            }
        }
        if($this->save() === false){
            $this->error ='编辑失败！';
            return false;
        }else{
            return true;
        }
    }
    /**
     * 删除权限
     */
    public function deletePermission($id){
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'lft','rght','parent_id','id','level');
        //首先删除关联表数据 及其他的后代
        $children = $nestedests -> getDescendants($id);
//        dump($children);exit;
        $ids = [];
        foreach ($children as $child){
            $ids[] = $child['id'];
        }
        if(M('RolePermission')->where(['permission_id'=>['in',$ids]])->delete() === false){
            $this->error = '删除关联关系失败！';
            return false;
        }
        //删除相关关联表的数据
        if(M('MenuPermission')->where(['permission_id'=>['in',$ids]])->delete() === false){
            $this->error = '删除关联关系失败！';
            return false;
        }
        //在删除权限
        if(!$perId = $nestedests->delete($id)){
            $this->error = '删除权限失败！';
            return false;
        }
        return true;
    }
}
