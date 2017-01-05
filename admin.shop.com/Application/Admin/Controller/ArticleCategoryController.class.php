<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 11:02
 */

namespace Admin\Controller;


use Think\Page;

class ArticleCategoryController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'文章分类管理',
            'add'=>'添加文章分类',
            'edit' => '编辑文章分类',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'文章分类管理';
        $this->assign('title',$title);
        $this->model = D('ArticleCategory');
    }

    /**
     * 文章分类管理页面
     */
    public function index(){
        //获取数据  分页
        $count = $this->model->count();
        $page = new Page($count,2);
        $lists = $this->model->limit($page->firstRow,$page->listRows)->select();
        //传输数据
        $this->assign('lists',$lists);
        $this->assign('pages',$page->show());
        //加载视图
        $this->display();
    }

    /**
     * 添加数据
     */
     public function add(){
         //判断是都提交数据
         if(IS_POST){
            //收集数据，验证表单数据
             if(!$this->model->create()){
                 $this->error(get_errors($this->model));
             }
            //执行添加方法
             $re = $this->model->add();
             if(!$re){
                 $this->error(get_errors($this->model));
             }else{
                 $this->success('添加成功！',U('index'));
             }
         }else{
             //加载添加视图
             $this->display();
         }
     }

    /**
     * 编辑分类
     * @param $id 主键id
     */
    public function edit($category_id){
        //判断是都提交数据
        if(IS_POST){
            //收集数据，验证表单数据
            $data = $this->model->create();
//            var_dump($data);exit;
            if(!$data){
                $this->error(get_errors($this->model));
            }
            if(!$data['category_status']){
                $this->model->where(['category_id'=>$category_id])->setField('category_status',0);
            }
            //执行编辑方法
            $re = $this->model->save();
            if($re === false){
                $this->error('修改失败！');
            }
            $this->success('修改成功！',U('index'));
        }else{
            // 获取分类ID 并转换为整数类型
            $category_id = I('get.category_id', 0, 'intval');
            if(!$category_id){
                $this->error('没有找到数据！');
            }
            //查询出id对应的数据
            $row = $this->model->find($category_id);
            //传输数据
            $this->assign('row',$row);
            //加载视图
            $this->display();
        }
    }
    public function delete($category_id){
        // 获取分类ID 并转换为整数类型
        $category_id = I('get.category_id', 0, 'intval');
        if(!$category_id){
            $this->error('没有找到数据！');
        }
        $re = $this->model->delete($category_id);
        if(!$re){
            $this->error(get_errors($this->model));
        }else{
            $this->success('删除成功！',U('index'));
        }
    }
}