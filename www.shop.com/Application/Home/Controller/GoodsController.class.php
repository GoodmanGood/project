<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/2
 * Time: 12:58
 */

namespace Home\Controller;


use Think\Controller;

class GoodsController extends Controller
{
    /**
     * @var \Admin\Model\GoodsModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('Goods');
    }
    /**
     * 相关商品分类的商品列表展示
     */
    public function category(){
        if(I('get.all')){
            $this->assign('all_goods',M('Goods')->order('id desc')->select());
//            $this->assign($this->model->allGoods());
        }
        $where = [];
        if($brand_id = I('get.brand_id', 0, 'intval')){
            $where['brand_id'] = $brand_id;
        }
        //获取商品分类
        $this->assign('lists',M('GoodsCategory')->where(['level'=>2])->select());
        //商品 分页
        $this->assign($this->model->categoryGoods(I('get.id'),$where));
        //当前的商品分类信息
        $this->assign('category',M('GoodsCategory')->find(I('get.id')));
        //商品品牌
        $this->assign('brands',M('Brand')->select());
        $this->display('product_list');
    }
    /**
     * 商品详情
     */
    public function goodInfo($id){
        //获取商品分类
        $this->assign('lists',M('GoodsCategory')->where(['level'=>2])->select());
        //当前商品信息 和 商品分类信息
        $good = M('Goods g')
            ->join('goods_category gc on g.category_id = gc.good_category_id')
            ->join('goods_detail gd on g.id = gd.goods_id')
            ->join('brand on g.brand_id = brand.good_brand_id')
            ->find($id);
//        dump($good);exit;
        $paths = M('GoodsGallery')
            ->where(['goods_id'=>$id])
            ->select();
//        dump($path);exit;
        $this->assign('good',$good);
        $this->assign('paths',$paths);
        $this->display('product');
    }
    /**
     * 文章内容
     */
    public function article($id){
        //获取商品分类
        $this->assign('lists',M('GoodsCategory')->where(['level'=>2])->select());
        $article = M('Article a')
            ->join('article_detail ad on a.article_id = ad.article_detail_id')
            ->find($id);
//        dump($articles);exit;
        $this->assign('article',$article);
        $this->display('');
    }
}