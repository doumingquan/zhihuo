<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

class Search extends Adminbase
{
    public function index()
    {
        $keywords = input('keywords');

        $serRes = db('admin')->order('id desc')->where('username', 'like', '%' . $keywords . '%')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where('is_delete!=2')->paginate(15, false, $config = ['query' => array('keywords' => $keywords)]);

        $this->assign(array(
            'serRes' => $serRes,
            'keywords' => $keywords,
        ));

        return view();
    }

    public function ajax_admin()
    {
        $id = input('id');
        $ajax_admin = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id' => $id))->find();

        $this->assign('ajax_admin', $ajax_admin);
        return ($ajax_admin);

        return $this->fetch('ad_list');
    }

}