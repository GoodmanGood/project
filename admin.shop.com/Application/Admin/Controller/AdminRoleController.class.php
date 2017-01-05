<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27
 * Time: 15:58
 */

namespace Admin\Controller;




class AdminRoleController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'角色管理',
            'add'=>'添加角色',
            'edit' => '角色文章',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'角色管理';
        $this->assign('title',$title);
        $this->model = D('AdminRole');
    }
    /**
     *角色首页
     */
    public function index(){
        $this->assign($this->model->getList());
        $this->display();
    }
    /**
     * 添加角色
     */
    public function add(){
        if(IS_POST){
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->addRole()){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $permissions = D('AdminPermission')->getList();
            $this->assign('permissions',json_encode($permissions));
            $this->display();
        }
    }
    /**
     * 编辑角色
     */
    public function edit(){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if($this->model->saveRole($data['role_id']) === false){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('index'));
        }else{
            //获取所有权限
            $permissions = D('AdminPermission')->getList();
            $this->assign('permissions',json_encode($permissions));
            //取出角色相关的所有权限
            $this->assign('row',$this->model->getRoleInfo(I('get.id')));
            $this->display();
        }
    }
    /**
     * 删除角色
     */
    public function delete($role_id){
    //删除关联表数据
        if(!M('RolePermission')->where(['role_id'=>$role_id])->delete()){
            $this->error(get_errors(M('RolePermission')));
        }
    //删除角色表数据
        if(!$this->model->delete($role_id)){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
}