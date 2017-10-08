<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 * 后台首页控制器
 */
class Admin extends Adminbase
{

    /**
     * 用户列表
     */

    //所有未审核员工的信息
    public function index()
    {
        //使用左连接查询
        $info = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where('is_delete!=2')->where('status=1')->paginate(15);
        //halt($info);exit;
        $this->assign('data', $info);
        // dump($info);
        return $this->fetch('user_list');
    }

    //员工详情
    public function detail()
    {
        $id = input('id');

        if (empty($id)) {
            $this->error('数据错误，请重试');
        }
        $admin = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id'=>$id))->find();

        $this->assign('admin', $admin);

        return view();
    }

    //公司员工列表
    public function ad_list()
    {
        //使用左连接查询
        $admin = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where('is_delete!=2')->where('status=2')->paginate(20);
        //halt($info);exit;
        $this->assign('admin', $admin);
        return view();
    }
    public function ajax_admin(){
     $id=input('id');
     $ajax_admin = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id'=>$id))->find();

        $this->assign('ajax_admin',$ajax_admin);
        return  ($ajax_admin);

       return $this->fetch('ad_list');
    }

    public function check_index()
    {
        //使用左连接查询
        $info = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where('is_delete!=2')->where('status=2')->paginate(15);
        //halt($info);exit;
        $this->assign('data', $info);
        // dump($info);
        return $this->fetch('user_checkedlists');
    }

    //所有员工薪资
    public function user_pay()
    {
        //使用左连接查询
        $info = db('pay')->alias('p')->field('p.*,a.username,a.entry_year')->join('admin a', 'a.id=p.admin_id', 'LEFT')->where('is_delete!=2')->select();
        //dump($info);
        // $info = db('pay')->alias('p')->field('')->join('admin a','a.id=p.admin_id','LEFT')->join('admin_depart d','a.depart_id=d.id','LEFT')->join('admin_company c','c.id=a.company_id','LEFT')->join('admin_position p','a.entry_pos=p.id','LEFT')->where('is_delete!=2')->paginate(2);
        //halt($info);exit;
        $this->assign('data', $info);
        // dump($info);
        return $this->fetch();
    }

    /**
     * 工资调整
     */
    public function adjust()
    {
        if (Request::instance()->isPost('')) {
            $data = input('post.');
            //halt($data);
            $id = $data['id'];
            $admin = db('admin')->field('salary,entry')->where(array('id' => $id))->find();
            if ($admin['salary'] == $data['salary']) {
                $this->error('薪资没有调整');
                exit;
            }
            //计算工龄

            $result = db('admin')->where(array('id' => $id))->update(array('salary' => $data['salary']));//更新个人总工资
            if ($result) {

                //创建新数据
                $info['admin_id'] = $data['id'];
                $info['adjust_salary'] = $data['adjust_salary'];
                $info['adjust_reason'] = $data['adjust_reason'];
                $info['update_user_id'] = session('admin.admin_id');
                $info['update_time'] = time();

                $result2 = db('pay')->insert($info);

                if ($result2) {
                    $this->success('调整成功!');

                } else {
                    $this->error('调整错误!');

                }
            } else {
                $this->error('操作失败!');
            }
        }


    }


    /**
     * 物理删除会员
     */
    public function delete_user($id)
    {
        if (Request::instance()->post()) {
            $id = input('id');
            $result = db('admin')->where(array('id' => $id))->update(array('is_delete' => 2));
            if ($result) {
                echo json_encode(array('status' => 1000, 'msg' => '删除成功!'));
            } else {
                echo json_encode(array('status' => 1001, 'msg' => '删除失败!'));
            }
        }
    }

//审核会员
    public function check_user($id)
    {
        if (Request::instance()->post()) {
            $id = input('id');
            echo $id;
            $result = db('admin')->where(array('id' => $id))->update(array('status' => 2));
            if ($result) {
                echo json_encode(array('status' => 1000, 'msg' => '审核成功!'));
            } else {
                echo json_encode(array('status' => 1001, 'msg' => '审核失败!'));
            }
        }
    }

//员工个人信息
    // public function my_center(){
    //     $id = session('admin.admin_id');//echo $id;
    // //学历
    //     $school = db('infomation')->where(array('title'=>1))->select();
    // //部门
    //     $depart = db('depart')->where(array('title'=>2))->select();//dump($depart);
    // //公司
    //     $company = db('company')->where(array('title'=>5))->select();
    // //职位
    //     $position = db('position')->where(array('title'=>4))->select();

    //     $info = db('admin')->alias('a')->where(array('id'=>$id))->find();     // halt($info);
    //     $this->assign('info',$info);
    //     $this->assign('school',$school);
    //     $this->assign('department',$depart);
    //     $this->assign('company',$company);
    //     $this->assign('position',$position);
    //     return  $this->fetch();
    // }

//个人修改个人信息


//个人薪资
    // public function my_salary(){
    //     //使用左连接查询
    //     $data = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position,pa.adjust_salary,adjust_reason,seniority')->join('admin_infomation i','i.id=a.schooling','LEFT')->join('admin_depart d','a.depart_id=d.id','LEFT')->join('admin_company c','c.id=a.company_id','LEFT')->join('admin_position p','a.entry_pos=p.id','LEFT')->join('admin_pay pa','pa.admin_id=a.id','LEFT')->where(array('a.id'=>session('admin.admin_id')))->paginate();
    // //  dump($data);
    //     $this->assign('data',$data);

    //     return $this->fetch();
    // }
    //个人修改个人信息
    public function changestatus(){
        if(request()->isAjax()){
            $id=input('id');
            $status=db('admin')->field('status')->where('id',$id)->find();
            $status=$status['status'];
            if($status==1){
                db('admin')->where('id',$id)->update(['status'=>2]);
                echo 1;//未审核
            }else{
                db('admin')->where('id',$id)->update(['status'=>1]);
                echo 2;//由审核
            }
        }else{
            $this->error("非法操作！");
        }
    }
    public function del($id){
        $del=db('admin')->delete($id);
        if($del){
            $this->success('删除管理员成功！','index');
        }else{
            $this->error('删除管理员失败！');
        }
    }




}
