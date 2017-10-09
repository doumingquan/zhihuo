<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 * 后台首页控制器
 */
class Company extends Adminbase
{

    public function index()
    {

        return view();
    }

    public function add()
    {
        $_company=db('company')->select();
        $this->assign('company',$_company);
        return view();
    }

    public function edit()
    {
        return view();
    }

    public function del()
    {
        return view();
    }

    public function ajaxdel()
    {
        return view();
    }



}
