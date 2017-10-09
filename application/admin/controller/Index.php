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
       // $statue=db('admin')->field('id,remark')->where(array('id'=>$id))->find();
       // $statue=$statue['remark'];
       $statue=session('admin_cate')['id'];//echo $statue;
       if($statue ==1){
           //完成数量
           $date=db('project')->where('is_delete!=2')->where('status=2')->count();
           $date2=db('project')->where('is_delete!=2')->where('status=1')->count();
           $date3=db('project')->where('is_delete!=2')->where('status=3')->count();
           
           $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
           $Begin = strtotime($BeginDate);//echo $Begin;
		        $last = strtotime("$BeginDate +1 month -1 day");
		   //echo $lastDate;
            $total1=db('project')->where('is_delete!=2')->where('status=1')->where('createtime','between',[$Begin,$last])->count();
            $total2=db('project')->where('is_delete!=2')->where('status=2')->where('createtime','between',[$Begin,$last])->count();
            $total3=db('project')->where('is_delete!=2')->where('status=3')->where('createtime','between',[$Begin,$last])->count();
          	// echo $total1;echo $total2;echo $total3;
           $this->assign('date',$date);
           $this->assign('date2',$date2);
           $this->assign('date3',$date3);
           $this->assign('total1',$total1);
           $this->assign('total2',$total2);
           $this->assign('total3',$total3);
        
          // $this->assign('date3',$date3);

           $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where('is_delete!=2')->order('id desc')->paginate(10);

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
           $date3=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=3')->count();
           $this->assign('date',$date);
           $this->assign('date2',$date2);
           $this->assign('date3',$date3);
           $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
           $Begin = strtotime($BeginDate);//echo $Begin;
		   $last = strtotime("$BeginDate +1 month -1 day");
		   //echo $lastDate;
            $total1=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=1')->where('createtime','between',[$Begin,$last])->count();
            $total2=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=2')->where('createtime','between',[$Begin,$last])->count();
            $total3=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=3')->where('createtime','between',[$Begin,$last])->count();
            //echo $total1;echo $total2;echo $total3;
            $this->assign('total1',$total1);
           	$this->assign('total2',$total2);
           	$this->assign('total3',$total3);
           $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->order('id desc')->paginate(10);
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
	   $this->success('退出成功、前往登录页面','index.php/admin/login/login');
   }
   public function ajax_list(){
       $id=$this->uid;
       //完成数量
       $ajax_list=db('project')->where("FIND_IN_SET($id, admin_id)")->where('is_delete!=2')->where('status=2')->count();
       return json_encode($ajax_list);
   }
}
