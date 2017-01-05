<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 18:06
 */

namespace Admin\Model;


use Think\Model;

class AdminModel extends Model
{
//开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['admin_password','/^[a-zA-Z]\w{5,17}$/','密码不符合格式!',0,'regex',3],
        ['admin_username','require','用户名不能为空！'],
        ['admin_password','require','密码不能为空！',0],
        ['admin_username','','用户名已存在!',1,'unique'],
        ['admin_username','/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/','用户名不合法！',3],
        ['re_password','admin_password','两次密码不一致!',0,'confirm',3],
        ['admin_email','email','邮箱格式不正确!',0],
    ];
    // 自动完成定义
    protected $_auto = array(
//        ['admin_password','md5',3,'callback'],
        ['add_time',NOW_TIME,1],
        ['admin_salt','salt',3,'callback'],
    );

    //盐
    public function salt(){
        return $salt = substr(base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM)),0,6);
    }
    /**
     * 获取管理员所的关联角色
     */
    public function getRoleInfo($id){
        $row = $this->find($id);
        $role_ids = D('RoleAdmin')->where(['admin_id'=>$id])->getField('role_id',true);
        $role_ids = json_encode($role_ids);
        $row['role_ids'] = $role_ids;
        return $row;
    }
    /**
     * 添加管理员
     */
    public function addAdmin($data){
        $admin_id = $this->add($data);
        $role_ids= I('post.role_id');
        if(empty($role_ids)){
            return true;
        }
        $roles = [];
        foreach($role_ids as $role_id){
            $roles[] = [
                'admin_id'=>$admin_id,
                'role_id'=>$role_id,
            ];
        }
        return M('RoleAdmin')->addAll($roles);
    }
    /**
     * 编辑管理员
     */
    public function saveAdmin(){
        $this->save();
        M('RoleAdmin')->where(['admin_id'=>I('post.admin_id')])->delete();
        $role_ids= I('post.role_id');
        if(empty($role_ids)){
            return true;
        }
        $roles = [];
        foreach($role_ids as $role_id){
            $roles[] = [
                'admin_id'=>I('post.admin_id'),
                'role_id'=>$role_id,
            ];
        }
        return M('RoleAdmin')->addAll($roles);
    }
    /**
     * 获取当前登录的管理员的所有权限
     */
    public function _getPermissions(){
        $admin_id = session('login_info.admin_id');
        $where = [
            'admin_id' => $admin_id,
        ];
        $row = M()->table('role_admin ra')
            ->join('role_permission rp on ra.role_id = rp.role_id')
            ->join('admin_permission ap on ap.id = permission_id')
            ->where($where)
            ->getField('permission_id,path');
//        var_dump($row);exit;
        //将当前登录的管理员的所有权限存入到session中 在行为中调用
        session('PERMISSIONS',$row);
    }
}