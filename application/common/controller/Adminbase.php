<?php

namespace app\common\controller;

use app\common\controller\Base;
use think\Request;
use auth\Auth;

/**
 * admin 基类控制器
 */
class AdminBase extends Base
{
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        parent::_initialize();
        $auth = new \think\Auth();
        $request = Request::instance();
        $m = $request->module();
        $c = $request->controller();
        $a = $request->action();
        $rule_name = $m . '/' . $c . '/' . $a;
        $this->assign('c', $c);
        //var_dump($rule_name);
        // 菜单
        $group = $auth->getGroups(session('user')['id']);
        $this->uid=(session('user')['id']);
        /*var_dump(session('user')['id']);*/
        $rules = explode(',', $group[0]['rules']);

        $menu = array();
        $map['pid'] = ['=', 0];
        $map['show'] = ['=', 1];
        $map['id'] = ['in', $rules];
        $_map['id'] = ['in', $rules];
        $menu = db('authRule')->where($map)->select();
        foreach ($menu as $k => $v) {
            $menu[$k]['children'] = db('authRule')->where($_map)->where(array('pid' => $v['id'], 'show' => 1))->select();
            foreach ($menu[$k]['children'] as $k1 => $v1) {
                $menu[$k]['children'][$k1]['children'] = db('authRule')->where($_map)->where(array('pid' => $v1['id'], 'show' => 1))->select();
            }
        }
        // // print_r($menu); die;
        $this->assign([
            'menu' => $menu,
        ]);

        // end菜单
        $result = $auth->check($rule_name, session('user')['id']);


        /*if (!$result) {
            $this->error('您没有权限访问');
        }*/

    }

    public function header_404(){
        require('404.html');
        exit();
    }


}
