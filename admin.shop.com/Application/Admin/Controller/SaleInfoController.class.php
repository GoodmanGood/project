<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:59
 */

namespace Admin\Controller;



class SaleInfoController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'活动管理',
            'add'=>'添加活动',
            'edit' => '编辑活动',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'商品分类管理';
        $this->assign('title',$title);
        $this->model = D('SaleInfo');
    }

    /**
     * 活动首页
     */
    public function index(){
        $this->assign('rows',$this->model->select());
        $this->display();
    }

    /**
     * 添加活动
     */
    public function add(){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->add()){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $this->display();
        }
    }

    /**
     * 编辑活动
     * @param $id
     */
    public function edit($id){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->save()){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('index'));
        }else{
            $this->assign('row',$this->model->find($id));
            $this->display();
        }
    }
    /**
     * 删除活动
     * @param $id 主键
     */
    public function delete($id){
        if($this->model->delete($id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
}