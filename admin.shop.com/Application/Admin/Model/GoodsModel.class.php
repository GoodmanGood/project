<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 22:38
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class GoodsModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['name','require','商品名不能为空'],
        ['market_price','/\d/','市场价格填写不正确!',1],
        ['shop_price','/\d/','本店价格填写不正确!',1],
    ];

    /**
     * 商品添加
     * @param $data
     * @return bool|mixed
     */
    public function addGood($data){
        $goods_id = $this->add($data);
//        dump($goods_id);exit;
        //详情
        $goodModel = M('GoodsDetail');
        $data1 = [
            'goods_id' => $goods_id,
            'goods_content' => I('post.goods_content','',false),
        ];
        $re = $goodModel->add($data1);

        if(!$re){
            $this->error = '商品详情添加失败！';
            return false;
        }
        //活动

        for($i=0;$i<count($data['goods_status']);$i++) {
            $data2 = [
                'goods_id' => $goods_id,
                'prom_type' => $data['goods_status'][$i],
            ];
            $re1 = M('GoodsSale')->add($data2);
        }
        if(!$re1){
            $this->error = '商品活动添加失败！';
            return false;
        }
        //相册
        $pic = [];
        $pic['gallery_path'] = I('post.gallery_path');
        $pic['goods_id'] = $goods_id;
        $re2 = $this->addPic($pic);
        if(!$re2){
            $this->error = '商品相册添加失败！';
            return false;
        }
        return $re;
    }

    /**
     * 相册添加
     * @param $id
     * @return bool|mixed
     */
    public function addPic($data){
        $picModel = M('GoodsGallery');
        for($i=0;$i<count($data['gallery_path']);$i++){
            $data2 = [
                'goods_id'=>$data['goods_id'],
                'gallery_path'=>$data['gallery_path'][$i],
            ];
            $re1 = $picModel->add($data2);
        }
        if(!$re1){
            $picModel->error = '商品相册添加失败！';
            return false;
        }
        return $re1;
    }

    /**
     * 编辑商品信息
     * @param $data
     */
    public function saveGood($data){

        $this->save($data);
        $goodModel = M('GoodsDetail');
        $data1 = [
            'goods_id' => $data['id'],
            'goods_content' => I('post.goods_content','',false),
        ];
        $goodModel->where(['goods_id'=>$data['id']])->save($data1);
        for($i=0;$i<count($data['goods_status']);$i++) {
            $data2 = [
                'goods_id' => $data['id'],
                'prom_type' => $data['goods_status'][$i],
            ];
            $re1 = M('GoodsSale')->add($data2);
        }
        if($re1 === false){
            $goodModel->error = '商品详情编辑失败！';
            return false;
        }
        return true;
    }
    public function search($where,$where2){
        if(!empty($where2)){
            $goods_arr = D('GoodsSale')->field('goods_id')->where($where2)->group('goods_id')->select();
            $goods_ids = array_column($goods_arr,'goods_id');
            $where['goods.id'] = ['in',$goods_ids];
        }
//        $where['goods_id'] =
        //查询出结果的总条数
        $count = M('Goods')
            ->join('LEFT JOIN goods_category ON goods_category.good_category_id=goods.category_id')
            ->where($where)
            ->count();
        //分页  分页条数
        $page = new Page($count,2);
        //根绝搜索数据 查询出结果集
        $lists = M('Goods')
            ->field('goods.*, goods_category.good_category_name as category_name, brand.name')
            ->join('LEFT JOIN goods_category ON goods_category.good_category_id=goods.category_id')
            ->join('LEFT JOIN brand ON brand.good_brand_id=goods.brand_id')
//                ->join('goods_sale on goods.id = goods_sale.goods_id')
            ->where($where)
            ->limit($page->firstRow,$page->listRows)
            ->select();
        //获取活动数据
        $rows = M('Goods_sale')
            ->join('sale_info on goods_sale.prom_type = sale_info.id')
            ->join('goods on goods.id = goods_sale.goods_id')
            ->select();
//        dump($lists);exit;
        return [
            'lists'=>$lists,
            'pages' =>$page->show(),
            'rows' =>$rows,
        ];
    }
}