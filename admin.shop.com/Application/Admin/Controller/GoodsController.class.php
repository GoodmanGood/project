<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 22:38
 */

namespace Admin\Controller;

use Think\Page;
class GoodsController extends BaseController
{
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $titles = [
            'index'=>'商品管理',
            'add'=>'添加商品',
            'edit' => '编辑商品',
        ];
        $title = isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'商品分类管理';
        $this->assign('title',$title);
        $this->model = D('Goods');
    }
    /**
     * 商品首页  商品搜索功能
     */
    public function index(){
        //搜索
        $where = [];
        $where2 = [];
        //判断是否传入了搜索值
        if(!empty($_GET)) {
            //商品名称
            if ($name = I('get.goods_name')) {
                $where['goods_name'] = ['LIKE', "%$name%"];
            }
            //分类
            if ($category_id = I('get.category_id', 0, 'intval')) {
                $where['category_id'] = $category_id;
            }
            //品牌
            if ($brand = I('get.brand_id', 0, 'intval')) {
                $where['brand_id'] = $brand;
            }
            //价格区间
            $min = I('get.min', 0, 'strip_tags');
            $max = I('get.max', 0, 'strip_tags');
            if (($min && $max) && $min > $max) {
                list($min, $max) = [$max, $min];
            }
            if ($min) {
                $where['shop_price'][] = ['EGT', $min];
            }
            if ($max) {
                $where['shop_price'][] = ['ELT', $max];
            }
            //商品活动的条件搜索
            if($prom_type = I('get.prom_type')){
                $where2['prom_type'] = ['in',$prom_type];
            }
        }

        //传输数据
        $this->assign($this->model->search($where,$where2));
        $this->assign('brands', M('Brand')->where(['status'=>['gt',-1]])->select());
        $this->assign('categories', M('GoodsCategory')->order('left_key')->select());
        $this->assign('sales',M('SaleInfo')->select());
        //加载视图
        $this->display();
    }

    /**
     * 添加商品
     */
    public function add(){
        if(IS_POST){

            if(($data = $this->model->create()) === false){
                $this->error(get_errors($this->model));
            }
//            dump($data);exit;
            //添加货号
            if(($data['sn'] = $this->good_sn($data['sn'])) === false){
                $this->error(get_errors($this->model));
            }
            if($this->model->addGood($data) === false){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('index'));
        }else{
            $row = D('GoodsCategory')->order('left_key')->select();
            $brands = D('Brand')->where(['status'=>1])->select();
            $sales = M('SaleInfo')->select();
            $this->assign('row',$row);
            $this->assign('brands',$brands);
            $this->assign('sales',$sales);
            $this->display();
        }
    }

    /**
     * 编辑商品
     * @param $id 主键
     */
    public function edit($id){
        if(IS_POST){
            // 提交数据之前 先将对应的活动全部从数据库中全部清除
            M('Goods_sale')->where(['goods_id'=>$id])->delete();
            //执行修改
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }
            if($this->model->saveGood($data) === false){
                $this->error(get_errors($this->model));
            }
            $this->success('修改成功！',U('index'));

        }else{
            //查询出商品对应的促销活动的关联表
            $p = M('Goods_sale')->join('sale_info on goods_sale.prom_type = sale_info.id')->
                where(['goods_id'=>$id])->select();
            //提取出对应活动的id
            $prom_type = array_column($p,'prom_type');
            //在存入到一个数组的键值中
            $prom['prom_type'] = $prom_type;
//            var_dump($prom);exit;
            $this->assign('ss',$prom);
            $this->assign('rows',D('GoodsCategory')->select());
            $this->assign('brands',D('Brand')->where(['status'=>1])->select());
           $this->assign('row',$this->model->join('goods_detail on goods.id = goods_detail.goods_id')->find($id));
            $this->assign('sales',M('SaleInfo')->select());

            $this->display();
        }
    }

    /**
     * 删除商品
     * @param $id 主键
     */
    public function delete($id){
//        var_dump($id);exit;
        if($this->model->delete($id) === false){
            $this->error(get_errors($this->model));
        }
        if(M('GoodsDetail')->where("goods_id=$id")->delete() === false){
            $this->error(get_errors(M('GoodsDetail')));
        }
        if(M('GoodsGallery')->where("goods_id=$id")->delete() === false){
            $this->error(get_errors(M('GoodsGallery')));
        }
        if(M('GoodsSale')->where("goods_id=$id")->delete() === false){
            $this->error(get_errors(M('GoodsSale')));
        }
        $this->success('删除成功！',U('index'));
    }


    /**
     * 货号
     */
    private function good_sn($sn){
        if(empty($sn)){
            $day = date('Ymd');
            //获取当天的第几个商品
            $goods_count = M('GoodsDayCount');
            //判断是否是今天的第一个商品
            if(!($count = $goods_count->getFieldByDay($day,'count'))){
                $count = 1;
                $data = [
                    'day' => $day,
                    'count' => $count,
                ];
                $goods_count->add($data);
            }else{
                $count++;
                $goods_count->where(['day'=>$day])->setInc('count',1);
            }
        }
        return $sn = $day.str_pad($count,5,'0',STR_PAD_LEFT);
    }

    /**
     * 上传相册
     */
    public function pics(){
        if(IS_POST){
           if(!$this->model->addPic(I('post.'))){
               $this->error('请选择图片上传！');
           }
            $this->success('相册上传成功！',U('pics',['id'=>I('post.goods_id')]));
        }else{
        $id = I('get.id');
//            ->join('goods on goods.id = goods_gallery.goods_id')
        $data = D('GoodsGallery')->where(['goods_id'=>$id])->select();
//            var_dump($data);exit;
        $this->assign('id',$id);
        $this->assign('data',$data);
        $this->display();
        }
    }

    /**
     * 删除相册图片
     * @param $id 主键
     */
    public function pic_delete(){
//        var_dump()
        if(M('GoodsGallery')->delete(I('get.gallery_id')) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('pics',['id'=>I('get.goods_id')]));
    }

    /**
     * 商品详情
     * @param $id
     */
    public function detail($id){
        $this->assign('row',$this->model->join('goods_category on goods.category_id = goods_category.good_category_id')->join('brand on brand.good_brand_id = goods.brand_id')->find($id));
        //获取活动数据
        $rows = M('Goods_sale')->where(['goods_id'=>$id])->join('sale_info on goods_sale.prom_type = sale_info.id')->select();
        //传输数据
        $this->assign('rows',$rows);
        $this->assign('info',$this->model->join('goods_detail on goods.id = goods_detail.goods_id')->find($id));
        $this->display();
    }

    /**
     * 搜索
     */
    public function search(){
        $where = [];
        if(!empty($_GET)){
            //商品名称
            if($name = I('get.goods_name')){
                $where['goods_name'] = ['LIKE',"%$name%"];
            }
            //分类
            if($category_id = I('get.category_id',0,'intval')){
                $where['category_id'] = $category_id;
            }
            //品牌
            if($brand = I('get.brand_id',0,'intval')){
                $where['brand_id'] = $brand;
            }
            //价格区间
            $min = I('get.min',0,'strip_tags');
            $max = I('get.max',0,'strip_tags');
            if(($min && $max) && $min>$max){
                list($min,$max) = [$max,$min];
            }
            if($min){
                $where['shop_price'][] = ['EGT',$min];
            }
            if($max){
                $where['shop_price'][] = ['ELT',$max];
            }

            $count = M('Goods')
                ->join('')
                ->where($where)
                ->count();
            $page = new Page($count,2);
            $lists = M('Goods')
                ->join()
                ->where($where)
                ->limit($page->firstRow,$page->listRows)
                ->select();

        }
        $this->assign('lists', $lists);
    }
}
