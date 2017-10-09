<?php

namespace app\admin\controller;
use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 * 公司控制模块
 */
class Company extends Adminbase
{

    public function index()
    {
        //获取栏目
        $_cateRes=db('company')->order('sort desc')->select();
        $cateRes=model('company')->catetree($_cateRes);
        $this->assign('cateRes',$cateRes);
        return view();
    }

    public function add()
    {

        if(request()->isPost()){
            $data=input('post.');
            $add=db('company')->insert($data);
            if($add){
                $this->success('添加公司成功！',url('index'));
            }else{
                $this->error('添加公司失败！');
            }
            return;
        }
        //获取公司名称
        $_company=db('company')->select();
        //接受栏目id
        $cateid=input('cateid');
        $this->assign('company',$_company);
        $this->assign('cateid',$cateid);
        return view();
    }

    public function edit()
    {
        if(request()->isPost()){
            $data=input('post.');
            //判断是否隐藏栏目
            $_data=array();
            foreach ($data as $k => $v) {
                $_data[]=$k;
            }
            if(!in_array('status', $_data)){
                $data['status']=1;
            }
            //执行栏目修改操作
            $save=db('company')->update($data);
            if($save!==false){
                $this->success('修改公司成功！',url('index'));
            }else{
                $this->error('修改公司失败！');
            }
            return;
        }

        //获取栏目
        $_cateRes=db('company')->select();
        $cateRes=model('company')->catetree($_cateRes);
        //接受栏目id
        $cateid=input('id');
        $cates=db('company')->find($cateid);
        $this->assign(array(
            'cateRes'=>$cateRes,
            'cates'=>$cates,

        ));
        return view();

    }

    public function del(){
        $id = input('id');
        $result = DB::name('company')->delete($id);
        if($result){
            echo json_encode(array('status'=>1000,'msg'=>'删除成功!'));
        }else{
            echo json_encode(array('status'=>1001,'msg'=>'删除失败!'));
        }

    }

    public function ajaxdel()
    {
        return view();
    }



}
