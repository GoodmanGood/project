<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/18
 * Time: 20:23
 */

namespace Admin\Controller;




use Think\Page;

class BrandController extends BaseController
{
    private $model;

    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'品牌管理',
            'add'=>'添加品牌',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'品牌管理';
        $this->assign('title',$title);
        $this->model = D('Brand');
    }

    /**
     * 品牌管理首页显示
     * 查询品牌列表 状态为显示和隐藏的
     */
    public function index(){
        //获取数据  分页
        $count = $this->model->where(['status'=>['gt',-1]])->count();
        $page = new Page($count,2);

        $rows = $this->model->getList($page);
        //传输数据
        $this->assign('rows',$rows);
        $this->assign('pages',$page->show());
        //加载视图
        $this->display();
    }


    /**
     * 添加品牌
     */
    public function add(){
        //判断提交数据
        if(IS_POST){
            //收集数据 create
            $data = $this->model->create();
            //判断是否验证成功
            if(!$data){
                $this->error(get_errors($this->model));
            }
//            var_dump($data);exit;
            //添加数据
            $result = $this->model->add($data);
            //判断是否添加成功  并跳转页面
            if(!$result){
                $this->error(get_errors($this->model));
            }else{
                $this->success('添加成功！',U('index'));
            }
        }else{
            //加载添加页面
            $this->display();
        }
    }

    /**
     * 编辑回显功能
     * @param $id 主键id
     */
    public function edit(){
        //判断提交数据
        if(IS_POST){
            //收集数据 create
            $data = $this->model->create();
//            var_dump($data);exit;
            if(!$data['status']){
                $this->model->where(['good_brand_id'=>$data['good_brand_id']])->setField('status',0);
            }
//            var_dump($data);die;
            //判断是否验证成功
            if(!$data){
                $this->error(get_errors($this->model));
            }
            //编辑功能
            $result = $this->model->save($data);
//            var_dump($result);exit;
            //判断是否修改成功  并跳转页面
            if($result === false){
                $this->error('修改失败！'.get_errors($this->model));
            }else{
                $this->success('修改成功！',U('index'));
            }

        }else{
            //获取id对应的数据
            $row = $this->model->find(I('get.good_brand_id'));
            //传输数据
            $this->assign('row',$row);
            //加载编辑页面
            $this->display();
        }
    }

    /**
     * 删除
     * @param $id 主键id
     */
    public function delete(){
        $re = $this->model->where(['good_brand_id'=>I('get.good_brand_id')])->setField('status',-1);
        if(!$re){
            $this->error('删除失败！'.get_errors($this->model));
        }else{
            $this->success('删除成功！',U('index'));
        }
    }
}
