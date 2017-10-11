<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 * 后台首页控制器
 */
class Pay extends Adminbase
{

    /**
     * 用户列表
     */
    public function index()
    {

        $info = db('pay')->order('id desc')->paginate(1);
        $this->assign('data', $info);
        // dump($info);
        return $this->fetch('pay_list');
    }

    /**
     * 删除管理员
     */
    public function delete_pay()
    {
        if (Request::instance()->isPost('')) {
            $id = input('id');
            $result = db('pay')->where(array('id' => $id))->update(array('status' => 2));
            if ($result) {
                echo json_encode(array('status' => 1000, 'msg' => '删除成功!'));
            } else {
                echo json_encode(array('status' => 1001, 'msg' => '删除失败!'));
            }
        }


    }


    /**
     * 修改管理员
     */
    public function edit_user($id)
    {

    }


}
