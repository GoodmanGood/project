<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 14:01
 */

namespace Admin\Controller;




class GoodsCategoryController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'商品分类管理',
            'add'=>'添加商品分类',
            'edit' => '编辑商品分类',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'商品分类管理';
        $this->assign('title',$title);
        $this->model = D('GoodsCategory');
    }

    /**
     * 商品分类管理页面
     */
    public function index(){
        $this->assign('rows',$this->model->getList());
        $this->display();
    }

    /**
     * 添加商品分类
     */
    public function add(){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if(!$this->model->addCategory($data)){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $this->_showCategory();
            $this->display();
        }
    }

    /**
     * 编辑回显商品分类
     * @param $id 主键id
     */
    public function edit($id){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if($this->model->saveCategory($data) === false){
                $this->error(get_errors($this->model));
            }
            $this->success('修改成功！',U('index'));
        }else{
            $this->_showCategory();
            $this->assign('info',$this->model->find($id));
            $this->display();
        }
    }

    /**
     * 删除分类
     * @param $id 主键id
     */
    public function delete(){
        $good_category_id = I('get.good_category_id');
//        var_dump($good_category_id);exit;
        if($this->model->daleteCategory($good_category_id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
    /**
     * 取出所有商品分类
     */
    private function _showCategory(){
        $categories = $this->model->getList();
        array_unshift($categories,['good_category_id'=> 0,'good_category_name'=>'顶级分类']);
        $this->assign('categories',$categories);
    }
}