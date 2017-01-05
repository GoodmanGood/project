<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 11:05
 */

namespace Admin\Model;


use Think\Model;

class ArticleModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['article_name','require','文章名不能为空！'],
    ];

    /**
     * 添加文章
     * @param $data
     * @return bool
     *
     */
    public function addArticle($data){
        $article_id = $this->add($data);
        $content = M('ArticleDetail');
        $data1 = [
            'article_detail_id' => $article_id,
            'content' => I('post.content','',false),
        ];
        $re = $content->add($data1);
        if(!$re){
            $content->error = '文章内容添加失败！';
            return false;
        }
        return $re;
    }

    /**
     * 查看文章
     * @param $article_id
     */
    public function findArticle($article_id){
        return $this->join('article_detail on article.article_id = article_detail.article_detail_id')->find($article_id);
    }

    /**
     * 编辑文章
     * @param $data
     * @return bool
     */
    public function editArticle($data,$article_id){
        $re = $this->save($data);
        if($re === false){
            $this->error = get_errors($this);
            return false;
        }

        $data1 = [
            'article_detail_id'=>$article_id,
            'content' => I('post.content','',false),
        ];
        $re1 = M('ArticleDetail')->save($data1);
        if($re1 === false){
            M('ArticleDetail')->error = '文章内容修改失败！';
            return false;
        }
//        var_dump($re);exit;
        return $re1;
    }

}