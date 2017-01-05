<?php
namespace Admin\Model;
use Think\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/18
 * Time: 20:39
 */
class BrandModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['name','require','品牌名不能为空！'],
    ];

    /**
     * 查询品牌列表数据 状态为显示和隐藏的
     *
     */
    public function getList($page){
        return $this->where(['status'=>['gt',-1]])->limit($page->firstRow,$page->listRows)->select();
    }
}