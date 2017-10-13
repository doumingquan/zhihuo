<?php
namespace app\admin\controller;
use app\common\controller\Adminbase;
use think\Db;
use think\Request;
/**
 * 后台首页控制器
 */
class Project extends Adminbase{

	/**
	 * 项目列表
	 */
	public function index(){
        // if(Request::instance()->get()){
            
        // }
        $cate=session('admin_cate');        //halt($cate);
        $cate_id = session('admin_cate')['id'];//echo $cate_id;
        $cateid = session('admin_cate')['cid'];
        if($cate_id==1 ){
            //超级管理员调出公司信息
           $info = db('company')->where('id',session('admin_cate')['cid'])->select();//dump($info); //总公司
           $resultid = model('company')->childrenids($cateid);  //dump($resultid);exit;//调出分公司的名称
           $data=Db::name('company')->where('id','in',$resultid)->select();//halt($info);
           $info = array_merge($info,$data);//dump($info);exit;
            $this->assign('admin', $info);
            return view();
           //dump($info);
        }elseif($cate_id==2){
            //一般管理员调出该公司所有项目信息
            $data = db('project')->alias('p')->field('p.*,po.position')->join('admin_company c','c.id=p.company_id')->join('admin_position po' , 'po.id=p.pro_style_id')->where('p.company_id',$cate['cid'])->where('is_delete!=2')->select();//dump($data);
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

            //$data2 = $data->paginate(15);halt($data);
            //dump($data);exit;
            $this->assign('data', $data);
            return view('index2');
        }else{
            //员工自己参与项目的信息
            $id=session('user')['id'];
            $data=db('project')->alias('p')->where("FIND_IN_SET($id, admin_id)")->join('admin_position po' , 'po.id=p.pro_style_id','LEFT')->where('p.is_delete!=2')->select();//halt($data);
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
            $this->assign('data',$data);
            return $this->fetch('index2');
        }
        //dump($cate);
  //       $info = db('project')->alias('p')->field()->join('admin_company c','c.id=p.company_id')->where('p.company_id',$cate['cid'])->select();
		// //dump($info);
  //       if($cate['id']==1){

  //       }elseif($cate['id']==4){


  //       }else{
            
  //       }
		// $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where('is_delete!=2')->select();
  //       foreach($data as $k=>$v){
  //           $arr = explode(',',$v['admin_id']);
  //           //dump($arr);
  //           $array = array();
  //           foreach ($arr as $vv){
  //               $admin_name = Db('admin')->field('id,username')->where(array('id'=>$vv))->find();
  //               array_push($array, $admin_name['username']);
  //               $data[$k]['username'] = implode(' ,',$array);               
  //           }           
  //       }
       
  //       // echo '<pre>';
  //       // print_r($data);
  //       // echo '</pre>';exit;
        
  //       $assign=array(
  //           'data'=>$data
  //           );

  //       $this->assign($assign);
  //       return $this->fetch();
	}

    public function index3($id){
        if(Request::instance()->get()){
            $keyword = input('keywords');
            $where['pro']=array('like',"%$keyword%");
        }
         $data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where('is_delete!=2')->where('company_id',$id)->where($where)->select();
        // dump($data);
        foreach($data as $k=>$v){
            $arr = explode(',',$v['admin_id']);
            //dump($arr);
            $array = array();
            foreach ($arr as $vv){
                $admin_name = Db('admin')->field('id,username')->where(array('id'=>$vv))->find();
                array_push($array, $admin_name['username']);
                $join = implode(' ,',$array);               
            } 
            $data[$k]['username'] = $join;        
        }
        //dump($data);
        $assign=array(
            'data'=>$data
           
            );

        $this->assign($assign);
        return $this->fetch();
        
    }

    /**
     * 添加项目
     */
    public function add(){
        $cid = session('admin_cate')['cid'];
        if(Request::instance()->post()){
            $data=input('post.');
    //dump($data);exit;
            $userdata=[
                'pro'=>$data['pro'],
                'cycle'=>$data['cycle'],
                'status'=>$data['status'],
                'company_id'=>$cid,
                'pro_style_id'=>$data['pro_style_id'],
                'desc'=>$data['desc'],
                'createtime'=>time()
            ];
             if (!empty($data['admin_ids'])) {                   
                    $userdata['admin_id'] = implode(',',$data['admin_ids']);                                   
                }                       
            $result=Db::name('project')->insert($userdata);           
            if($result){
                // 操作成功
                $this->success('添加成功','Admin/project/index');
            }else{
                $this->error('添加失败');
            }
        }else{
            $data = db('position')->select();
            $user = DB::name('admin')->field('id,username')->where('company_id',session('admin_cate')['cid'])->select();
            if(session('admin_cate')['id']==1){
                $info = Db::name('company')->field('company')->select(); 
            }else{
                  $info = Db::name('company')->field('company')->where('id',$cid)->find();          //dump($info
            }
          
            $assign=array(
                'data'=>$data,
                'user'=>$user,
                'info'=>$info
                );

            $this->assign($assign);
            return $this->fetch();
        }
    }

    public function edit($id){
        if(Request::instance()->post()){
            $data=input('post.');
            //var_dump($data);
            $userdata=[
                'pro'=>$data['pro'],
                'cycle'=>$data['cycle'],
                'status'=>$data['status'],
                'company_id'=>$data['company_id'],
                'pro_style_id'=>$data['pro_style_id'],
                'desc'=>$data['desc'],
                'createtime'=>time()
            ];
             if (!empty($data['admin_ids'])) {                   
                    $userdata['admin_id'] = implode(',',$data['admin_ids']);                                   
                }                       
            $result=Db::name('project')->where(array('id'=>$data['id']))->update($userdata);           
            if($result){
                // 操作成功
                $this->success('修改成功','Admin/project/index');
            }else{
                $this->error('修改失败');
            }
        }else{
          
            $data = DB::name('project')->where(array('id'=>$id))->find();//dump($data);
            $admin_id = $data['admin_id'];
            $info=db('admin')->field('username')->where("id", 'in',"$admin_id")->select();//dump($info);
            $array = array();
            foreach ($info as $key => $value) {
                array_push($array,$value['username']);           
            }
            //dump($array);
            //取出该公司下的所有员工
            $user = DB::name('admin')->field('id,username')->where('company_id',session('admin_cate')['cid'])->select();//dump($info);
            $company = DB::name('company')->select();
      
            $position = db('position')->select();
            // $user = DB::name('admin')->field('id,username')->select();
            $this->assign('position',$position);
            $this->assign('string',$array);
            $this->assign('company',$company);
            $this->assign('user',$user);
            $this->assign('data',$data);

            return $this->fetch();
        }
    }

    public function delete(){
          $id = input('id');echo $id;
            $result = DB::name('project')->where(array('id'=>$id))->update(array('is_delete'=>2));
            if($result){
                echo json_encode(array('status'=>1000,'msg'=>'删除成功!'));
            }else{
                echo json_encode(array('status'=>1001,'msg'=>'删除失败!'));
            }

    }


}
