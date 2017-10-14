<?php

namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;
use think\Request;

/**
 * 后台首页控制器
 */
class Staff extends Adminbase
{


//员工个人信息
    public function my_center()
    {
        $cate_id = session('admin_cate')['id'];//echo $cate_id;

        $id = session('admin.admin_id');//echo $id;
        //学历
        $school = db('infomation')->where(array('title' => 1))->select();
        //部门
        $depart = db('depart')->where(array('title' => 2))->select();//dump($depart);
        //公司
        $company = db('company')->where(array('title' => 5))->select();
        //职位
        $position = db('position')->where(array('title' => 4))->select();
        $info = db('admin')->alias('a')->field('a.*,c.company')->join('admin_company c','c.id=a.company_id')->where(array('a.id' => $id))->find();
        if ($info['birthday'] == 0) {
            $info['birthday'] = "";
        }
        if ($info['age'] == 0) {
            $info['age'] = "";
        }
        if ($info['height'] == 0) {
            $info['height'] = "";
        }
        //halt($info);
        $this->assign('info', $info);
        $this->assign('school', $school);
        $this->assign('department', $depart);
        $this->assign('company', $company);
        $this->assign('position', $position);
        if ($cate_id == 2){
            return $this->fetch('company_center');
        }else{
            return $this->fetch();
        }

    }


//个人薪资
    public function my_salary()
    {

        //使用左连接查询
        $data = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position,pa.adjust_salary,adjust_reason,seniority')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->join('admin_pay pa', 'pa.admin_id=a.id', 'LEFT')->where(array('a.id' => session('admin.admin_id')))->paginate();
        //  dump($data);
        $this->assign('data', $data);

        return $this->fetch();
    }


    //员工个人信息展示
    public function index()
    {
        $cate=session('admin_cate')['cid'];

        $cate_id = session('admin_cate')['id'];//echo $cate_id;
        if($cate_id == 1){
            //使用左连接查询
            $data = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id' => session('admin.admin_id')))->find();
            // dump($data);
            $this->assign('data', $data);
            return $this->fetch();
        }elseif($cate_id == 2){
            //统计公司信息
         $count_user=db('admin')->field('id,company_id')->where(array('company_id'=>$cate))->count();
         $count_project=db('project')->where(array('company_id'=>$cate,'status'=>1))->count();
         $count_project2=db('project')->where(array('company_id'=>$cate,'status'=>2))->count();
            $this->assign([
                'count_user'  => $count_user,
                'count_project' => $count_project,
                'count_project2'=>$count_project2,
            ]);
            $data = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id' => session('admin.admin_id')))->find();
            // dump($data);
            $this->assign('data', $data);
            return view('index2');
        }else{
            //使用左连接查询
            $data = db('admin')->alias('a')->field('a.*,i.name,d.depart,c.company,p.position')->join('admin_infomation i', 'i.id=a.schooling', 'LEFT')->join('admin_depart d', 'a.depart_id=d.id', 'LEFT')->join('admin_company c', 'c.id=a.company_id', 'LEFT')->join('admin_position p', 'a.entry_pos=p.id', 'LEFT')->where(array('a.id' => session('admin.admin_id')))->find();
            // dump($data);
            $this->assign('data', $data);
            return $this->fetch();
        }

    }

    //个人修改个人信息
    public function change_msg()
    {
        if (Request::instance()->post()) {
            $data = input('post.');
            $admin_pass = db('admin')->field('password')->where('id', session('user')['id'])->find();
            if (empty($data['password'])) {
                $data['password'] = $admin_pass['password'];
            } else {
                $data['password'] = md5($data['password']);
            }
            $entry = $data['entry'];
            $userpic = DB::name('admin')->field('headpic')->where(array('id' => session('admin.admin_id')))->find();
            if (!empty($userpic['headpic'])) {
                unlink($userpic['headpic']);
            }
            $file = request()->file('headpic');
            if ($file) {
                $info = $file->validate(['size' => 1567833, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $pics = ROOT_PATH . 'public' . DS . 'uploads' . DS . $info->getSaveName();//echo $pics;
                    $image = \think\Image::open($pics);         //dump($image);
                    $image->thumb(150, 150);
                    $pics_small = 'uploads' . DS . $info->getSaveName();
                    $image->save($pics_small);

                    $data['headpic'] = $pics_small;
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
            $data['birthday'] = strtotime($data['birthday']);

            $data['create_user_id'] = session('admin.admin_id');
            $data['create_time'] = time();
            //计算工龄
            $datenow = date('Y-m-d', time()); 
            // dump($data['birthday']);  
            // dump($data['create_time']); 
            $age1 = date('Y',$data['create_time']);
            $age2 = date('Y',$data['birthday']);
            $data['age'] =  $age1-$age2;//halt($data['age']) ;
            $result = model('admin/admin')->diffDate($datenow, $entry);//halt($result);
            if ($result['year'] == '0') {
                if ($result['month'] == '0') {
                    $data['entry_year'] = $result['day'] . '天';
                } else {
                    if ($result['day'] == '0') {
                        $data['entry_year'] = $result['month'] . '月';
                    } else {
                        $data['entry_year'] = $result['month'] . '月' . $result['day'] . '天';
                    }
                }
            } else {
                if ($result['month'] != '0' && $result['day'] != '0') {
                    $data['entry_year'] = $result['year'] . '年' . $result['month'] . '月' . $result['day'] . '天';
                } elseif ($result['month'] == '0') {
                    $data['entry_year'] = $result['year'] . '年' . $result['day'] . '天';
                } else {
                    $data['entry_year'] = $result['year'] . '年' . $result['month'] . '月';
                }
            }

            $info = db('admin')->where(array('id' => session('admin.admin_id')))->update($data);
            if ($info) {
                $this->success('操作成功!');
            } else {
                $this->error('操作失败!');
            }
        }
    }


}
