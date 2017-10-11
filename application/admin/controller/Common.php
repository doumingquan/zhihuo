<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

//common控制器 控制不允许未进行登录就访问，就跳到登录页面
class Common extends Controller
{
    public function __construct(Request $request)
    {

        parent::__construct($request);//调用父类的构造函数,如果没有session就跳到登录页面
        if (!session('admin.admin_id')) {
            $this->redirect('admin/login/login');
        }
    }

}

?>