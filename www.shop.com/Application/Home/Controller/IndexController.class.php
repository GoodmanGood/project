<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    /**
     * 前台首页
     */
    public function index(){
//        phpinfo();exit;
        //获取商品分类
        $this->assign('lists',M('GoodsCategory')->where(['level'=>2])->select());
        //获取最新商品
//        if(!$goods_new = S('goods_new')){
            $goods_new =M('Goods')->order('id desc')->limit(4)->select();
//            S('goods_new',$goods_new,300);
//            echo 'huancun';
//        }
        $this->assign('new_goods',$goods_new);
        //获取全部商品
        $this->assign('all_goods',M('Goods')->order('id desc')->select());
        //全部文章 前五条
        $articles = M('ArticleCategory ac')
            ->field('ac.category_name,ac.category_id,a.article_name,a.article_id')
//            ->distinct(true)
            ->join('article a on ac.category_id = a.article_category_id')
            ->order('category_sort')
            ->select();
        $this->assign('articles',$articles);
//        dump($articles);exit;
        //文章分类
        $this->assign('category',M('ArticleCategory')->order('category_sort')->limit(4)->select());
        $this->display('index');
    }

}