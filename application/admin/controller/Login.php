<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Admin;

class Login extends Controller
{
    public function login()
    {
        //$info=db('admin')->select();dump($info);//数据库链接成功
        //判断是不是post方式
        if (request()->ispost()) {
            $data = input('post.');
            // halt($data);exit;
            if (!captcha_check($data['code'])) {
                //  //验证失败
                $this->error('验证码错误！');
                exit;
            };
            // halt(input('post.'));
            //调用admin模型
            $info = (new Admin())->login(input('post.'));//halt($info);
            if ($info['status']) {
                $this->success($info['msg'], 'admin/index/index');
                exit;
            } else {
                $this->error($info['msg']);
            }
            //dump($info);
        }
        return $this->fetch();
    }
}
