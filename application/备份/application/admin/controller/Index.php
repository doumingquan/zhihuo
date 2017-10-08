<?php
namespace app\admin\controller;
use app\common\controller\Adminbase;
use think\Db;
class Index extends Adminbase
{
    //protected $user_model,$role_model;
   public function index()
   {
      // echo 123;
      return $this->fetch();
   }
   
   public function logout(){
	   session('admin.admin_id',null);
	   session('admin.admin_name',null);
	   $this->success('退出成功、前往登录页面','Home/Index/index');
   }
}
