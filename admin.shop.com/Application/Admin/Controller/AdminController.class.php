<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 18:15
 */

namespace Admin\Controller;


use Think\Page;

class AdminController extends BaseController
{
    /**
     * @var \Admin\Model\AdminModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('Admin');
    }
    //管理员列表
    public function index(){
        $count = $this->model->count();
        $page = new Page($count,2);
        $this->assign('rows',$this->model->page(I('get.p', 1), 2)->select());
        $this->assign('pages',$page->show());
        $this->display();
    }
    //添加管理员
    public function add(){
        if(IS_POST){
            if(!$data = $this->model->create()){
                $this->error(get_errors($this->model));
            }

            $data['admin_password'] = md5(md5($data['admin_password']).$data['admin_salt']);
            $re = $this->model->addAdmin($data);
            if(!$re){
                $this->error(get_errors($this->model));
            }
            $this->success('设置成功！',U('index'));
        }else{
            $roles = M('AdminRole')->order('role_sort')->select();
            $this->assign('roles',json_encode($roles));
            $this->display();
        }
    }
    //编辑管理员
    public function edit($admin_id){
        if(IS_POST){
//            dump($this->model->data());die;
            if(!$this->model->create()){
                $this->error(get_errors($this->model));
            }
            if($this->model->saveAdmin() === false){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('index'));
        }else{
            $roles = M('AdminRole')->order('role_sort')->select();
            $this->assign('roles',json_encode($roles));
            $this->assign('row',$this->model->getRoleInfo($admin_id));
            $this->display();
        }
    }
    //修改密码
    public function update($admin_id){
        if(IS_POST){
            if(!I('post.old_password')){
                $this->error('请输入您的原始密码');
            }
            $user = $this->model->find($admin_id);
            $pwd = md5(md5(I('post.old_password')).$user['admin_salt']);
            if($pwd !== $user['admin_password']){
                $this->error('旧密码输入错误！');
            }
            $data = $this->model->create();
            if(!$data){
                $this->error(get_errors($this->model));
            }
            $data['admin_password'] = md5(md5($data['admin_password']).$data['admin_salt']);

            if(!$this->model->save($data)){
                $this->error(get_errors($this->model));
            }
            $this->success('密码修改成功！请重新登录',U('Login/logout'));
        }else{
            $this->assign('row',$this->model->find($admin_id));
            $this->display('editPwd');
        }
    }
    //删除管理员
    public function delete($admin_id){
        if(M('RoleAdmin')->where(['admin_id'=>$admin_id])->delete() ===false){
            $this->error(get_errors($this->model));
        }
        if($this->model->delete($admin_id) ===false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('index'));
    }
}