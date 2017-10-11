<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 *
 * 后台部门管理
 */
class Depart extends AdminBase
{

//******************部门***********************

    /*部门列表*/
    public function depart_list()
    {
        //  $data=Db::name('auth_rule')->getTreeData('tree','id','title');dump($data);exit;
        $data = Db::name('depart')->select();     //dump($data);exit;
        //dump($data);
        $assign = array(
            'data' => $data
        );

        $this->assign($assign);
        return $this->fetch();
    }

    /**
     * 添加部门
     */
    public function add()
    {
        $data = input('post.');//halt($data);
        unset($data['id']);
        $result = Db::name('depart')->insert($data);
        if ($result) {
            $this->success('添加成功', 'Admin/Depart/depart_list');
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 修改部门
     */
    public function edit()
    {
        $data = input('post.'); //halt($data);
        $info = ['depart' => $data['depart']];
        $result = Db::name('depart')->where(["id" => $data['id']])->update($info);
        // $result=\app\admin\model\Admin::change(["id"=>$data['id']],$info);
        if ($result) {
            $this->success('修改成功', 'Admin/Depart/depart_list');
        } else {
            $this->error('您没有做任何修改');
        }
    }

    /**
     * 删除部门
     */
    public function delete($id)
    {
        $map = array(
            'id' => $id
        );
        $result = Db::name('depart')->delete($map);
        if ($result) {
            $this->success('删除成功', 'Admin/Depart/depart_list');
        } else {
            $this->error('删除失败');
        }

    }

}
