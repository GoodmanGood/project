<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/28
 * Time: 17:31
 */

namespace Admin\Controller;



class MenuController extends BaseController
{
    /**
     * @var \Admin\Model\MenuModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'菜单管理',
            'add'=>'添加菜单',
            'edit' => '编辑菜单',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'菜单管理';
        $this->assign('title',$title);
        $this->model = D('Menu');
    }

    /**
     * 菜单展示
     */
    public function index(){
        $this->assign('lists',$this->model->order('lft')->select());
        $this->display();
    }
    /**
     * 添加菜单
     */
    public function add(){
        if(IS_POST){
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->addMenu()){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $permissions = D('AdminPermission')->getList();
            $this->assign('permissions',json_encode($permissions));
            $lists = $this->model->order('lft')->select();
            array_unshift($lists,['id'=>0,'menu_name'=>'顶级分类','level'=>0,'parent_id'=>0]);
            $this->assign('lists',$lists);
            $this->display();
        }
    }
    /**
     * 编辑菜单
     */
    public function edit($id){
        if(IS_POST){
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->saveMenu()){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('index'));
        }else{
            //查询出所有菜单分类
            $lists = $this->model->order('lft')->select();
            array_unshift($lists,['id'=>0,'menu_name'=>'顶级分类','level'=>0,'parent_id'=>0]);
            $this->assign('lists',$lists);
            $permissions = D('AdminPermission')->getList();
            $this->assign('permissions',json_encode($permissions));
            //当前菜单的所有关联权限
            $row = $this->model->getMenuInfo($id);
//            var_dump($row);exit;
            $this->assign('row',$row);
            $this->display();
        }
    }
    /**
     * 删除菜单 及其关联表的相应权限数据
     */
    public function delete($id){
        //删除菜单表数据
        if($this->model->deleteMenu($id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
}