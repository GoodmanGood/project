<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 14:10
 */

namespace Admin\Model;


use Admin\Logic\MysqlDb;
use Admin\Logic\NestedSets;
use Think\Model;

class GoodsCategoryModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['good_category_name','require','商品分类不能为空'],
    ];
    /**
     * 查询所有分类 并通过左节点排序
     */
    public function getList(){
        return $this->order('left_key')->select();
    }

    /**
     * 添加商品分类
     * @param $data 表单数据 数组
     */
    public function addCategory($data){
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'left_key','right_key','parent_id','good_category_id','level');
        if(!$catId = $nestedests->insert($data['parent_id'],$data,'bottom')){
            $this->error = '新建分类失败！';
            return false;
        }
        return $catId;
    }

    /**
     * 编辑商品分类  重新计算所有左右节点和层级
     * @param $data 表单数据 数组
     */
    public function saveCategory($data){
//        var_dump($data);exit;
        //判断父级分类是否修改
        $pid = $data['parent_id'];
        //获取数据库中原来的父类id，使用getField方法不会调用find方法，就不会覆盖当前的data的值
        $old_pid = $this->where(['good_category_id'=>$data['good_category_id']])->getField('parent_id');
        //当当前的父类id不等于数据库中原有的父类id时  执行修改父类方法
        if($pid != $old_pid){
            $orm = new MysqlDb();
            $nestedests = new NestedSets($orm,$this->getTableName(),'left_key','right_key','parent_id','good_category_id','level');
            if(!$nestedests->moveUnder($data['good_category_id'],$data['parent_id'],'bottom')){
                $this->error = '父级分类不合法！';
                return false;
            }
        }
        //执行修改方法  并返回被影响的行数
        return $this->save();
    }

    /**
     * 删除分类 分类下有商品的不能被删除
     * @param $id 主键id
     */
    public function daleteCategory($good_category_id){
        $orm = new MysqlDb();
        $nestedests = new NestedSets($orm,$this->getTableName(),'left_key','right_key','parent_id','good_category_id','level');
        //找到所有的后代分类
        $descendants = $nestedests->getDescendants($good_category_id);
        //获取所有的后代分类id
        $ids = [];
        foreach ($descendants as $descendant) {
            $ids[] = $descendant['good_category_id'];
        }
        //如果后代分类id为空
        if(empty($ids)){
            return false;
        }
        //查询商品表  是否有该商品分类下的商品
        $goodsModel = M('Goods');
        $count = $goodsModel->where(['category_id'=>['in',$ids]])->count();
        //判断是否有该商品分类下的商品
        if($count){
            $this->error = '该分类下有商品，不能被删除！';
            return false;
        }
        if($nestedests->delete($good_category_id) === false){
            $this->error = '删除失败！';
            return false;
        }
        return true;
    }
}