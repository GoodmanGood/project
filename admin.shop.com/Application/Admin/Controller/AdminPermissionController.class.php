<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27
 * Time: 11:41
 */

namespace Admin\Controller;




class AdminPermissionController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'权限管理',
            'add'=>'添加权限',
            'edit' => '编辑权限',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'权限管理';
        $this->assign('title',$title);
        $this->model = D('AdminPermission');
    }
    /**
     * 权限首页展示
     */
    public function index(){
        $perm = $this->model->getList();
        $this->assign('lists',$perm);
        $this->display();
    }
    /**
     * 添加权限
     */
    public function add(){
        if(IS_POST){
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->addPermission()){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $this->_showPermission();
            $this->display();
        }
    }

    /**
     * 编辑权限
     * @param $permission_id 主键id
     */
    public function edit($id){
        if(IS_POST){
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if($this->model->savePermission($id) === false){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('index'));
        }else{
            $this->_showPermission();
            $this->assign('row',$this->model->find($id));
            $this->display();
        }
    }

    /**
     * 删除权限
     * @param $permission_id 主键
     */
    public function delete($id){
        if($this->model->deletePermission($id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
    /**
     * 权限列表
     */
    public function _showPermission(){
        $perm = $this->model->getList();
        array_unshift($perm,['id'=>0,'permission_name'=>'顶级分类']);
        $this->assign('lists',$perm);
    }
}