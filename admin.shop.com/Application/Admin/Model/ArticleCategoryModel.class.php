<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 11:05
 */

namespace Admin\Model;


use Think\Model;

class ArticleCategoryModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['category_name','require','文章名不能为空'],
    ];


}