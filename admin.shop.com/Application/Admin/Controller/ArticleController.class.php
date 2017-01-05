<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 11:02
 */

namespace Admin\Controller;


use Think\Page;
class ArticleController extends  BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'文章管理',
            'add'=>'添加文章',
            'edit' => '编辑文章',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'文章分类管理';
        $this->assign('title',$title);
        $this->model = D('Article');
    }

    /**
     * 文章管理页面
     */
    public function index(){
        //分页
        //获取总条数
        $totalCount = $this->model->count();
        $page = new Page($totalCount, 2);

        //获取数据
        $lists = $this->model->join(' article_category on article.article_category_id = article_category.category_id')->limit($page->firstRow, $page->listRows)->select();
        //传输数据
        $this->assign('lists',$lists);
        $this->assign('pages', $page->show());
        //加载视图
        $this->display();
    }

    /**
     * 添加文章
     *
     */
    public function add(){
        //判断是都提交数据
        if(IS_POST){
            //收集数据，验证表单数据
            $data = $this->model->create();
//            var_dump(I('post.content'));exit;
            if(!$data){
                $this->error(get_errors($this->model));
            }
            //执行添加方法
            $re = $this->model->addArticle($data);
            //添加到文章内容表
            if(!$re){
                $this->error(get_errors($this->model));
            }else{
                $this->success('添加成功！',U('index'));
            }
        }else{
            //获取数据
           $categories = D('ArticleCategory')->where(['category_status'=>1])->select();
            //传输数据
            $this->assign('categories',$categories);
            //加载添加视图
            $this->display();
        }
    }

    /**
     * 编辑文章
     * @param $id 主键ID
     */
    public function edit($article_id){
        //判断是都提交数据
        if(IS_POST){
            //收集数据，验证表单数据
            $data = $this->model->create();
            if(!$data){
                $this->error(get_errors($this->model));
            }
            if(!$data['article_status']){
                $this->model->where(['article_id'=>$article_id])->setField('article_status',0);
            }
            //执行编辑方法
            $re = $this->model->editArticle($data,$article_id);
            if($re !== false){
                $this->success('修改成功！',U('index'));
            }else{
                $this->error(get_errors($this->model));
            }

        }else{
            // 获取分类ID 并转换为整数类型
            $article_id = I('get.article_id', 0, 'intval');
            if(!$article_id){
                $this->error('没有找到数据！');
            }
            //查询出id对应的数据
            $row = $this->model->find($article_id);
            $cate = D('ArticleCategory')->select();
            $info = D('ArticleDetail')->find($article_id);
            //传输数据
            $this->assign('row',$row);
            $this->assign('cate',$cate);
            $this->assign('info',$info);
            //加载视图
            $this->display();
        }
    }

    /**
     * 删除
     * @param $article_id 主键ID
     */
    public function delete(){
        // 获取分类ID 并转换为整数类型
        $article_id = I('get.article_id', 0, 'intval');
        if(!$article_id){
            $this->error('没有找到数据！');
        }
        $re = $this->model->delete($article_id);
        $res = M('ArticleDetail')->delete($article_id);
        if($re === false || $res === false){
            $this->error('删除失败！',get_errors($this->model));
        }else{
            $this->success('删除成功！',U('index'));
        }
    }

    public function show($article_id){
        //获取数据
        $row = $this->model->findArticle($article_id);
        //传输数据
        $this->assign('row',$row);
        //加载页面
        $this->display();
    }
}