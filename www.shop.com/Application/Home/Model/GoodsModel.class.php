<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/2
 * Time: 12:52
 */

namespace Home\Model;


use Think\Model;
use Think\Page;

class GoodsModel extends Model
{
    /**
     * 商品品牌的相关商品
     */
    public function categoryGoods($id,$where){
        $goods = M('Goods g')
            ->join('goods_category gc on g.category_id = gc.good_category_id')
            ->where(['gc.good_category_id'=>$id])
            ->where($where)
            ->page(I('get.p', 1), 4)
            ->select();
        $count = M('Goods g')
            ->join('goods_category gc on g.category_id = gc.good_category_id')
            ->where(['gc.good_category_id'=>$id])
            ->where($where)
            ->count();
        $page = new Page($count,4);
        return [
            'goods'=>$goods,
            'pages'=>$page->show(),
        ];
    }
    /**
     * 全部结果
     */
    public function allGoods(){
        $all_goods = M('Goods')->order('id desc')->select();
        $count = M('Goods')->order('id desc')->select();
        $page = new Page($count,4);

        return [
            'all_goods' => $all_goods,
            'pages' => $page->show(),
        ];
    }
}