<?php
namespace app\admin\controller;
use app\common\controller\Adminbase;
use think\Db;
class Index extends Adminbase
{
    //protected $user_model,$role_model;
   public function index()
   {

       $id=$this->uid;
       $statue=db('admin')->field('id,remark')->where(array('id'=>$id))->find();
       $statue=$statue['remark'];
       if($statue ==1){
           //完成数量
           $date=db('project')->where('is_delete!=2')->where('status=2')->count();
           $date2=db('project')->where('is_delete!=2')->where('status=1')->count();
           $this->assign('date',$date);
           $this->assign('date2',$date2);

           $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where('is_delete!=2')->paginate(10);
           foreach($data as $k=>$v){
               $arr = explode(',',$v['admin_id']);
               //dump($arr);
               $array = array();
               foreach ($arr as $vv){
                   $admin_name = Db('admin')->field('id,username')->where(array('id'=>$vv))->find();
                   array_push($array, $admin_name['username']);
                   $data[$k]['username'] = implode(' ,',$array);
               }
           }
           // echo '<pre>';
           // print_r($data);
           // echo '</pre>';exit;
           $assign=array(
               'data'=>$data
           );
           $this->assign($assign);
           return $this->fetch('index2');
       }else

           {
           //完成数量
           $date=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=2')->count();
           $date2=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=1')->count();
           $this->assign('date',$date);
           $this->assign('date2',$date2);

           $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->paginate(10);
           foreach($data as $k=>$v){
               $arr = explode(',',$v['admin_id']);
               //dump($arr);
               $array = array();
               foreach ($arr as $vv){
                   $admin_name = Db('admin')->field('id,username')->where(array('id'=>$vv))->find();
                   array_push($array, $admin_name['username']);
                   $data[$k]['username'] = implode(' ,',$array);
               }
           }
           // echo '<pre>';
           // print_r($data);
           // echo '</pre>';exit;
           $assign=array(
               'data'=>$data
           );
           $this->assign($assign);
           return $this->fetch('index');
       }

   }
   
   public function logout(){
	   session('admin.admin_id',null);
	   session('user',null);
	   $this->success('退出成功、前往登录页面','/login/login');
   }
   public function ajax_list(){
       $id=$this->uid;
       //完成数量
       $ajax_list=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=2')->count();
       return json_encode($ajax_list);
   }
}
