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
	 * 用户列表
	 */
	public function index(){
		
		$data=Db::name('project')->alias('p')->field('p.*,po.position')->join('admin_position po' , 'po.id=p.pro_style_id')->where('is_delete!=2')->select();
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
        return $this->fetch();
	}

    /**
     * 添加管理员
     */
    public function add(){
        if(Request::instance()->post()){
            $data=input('post.');
    //dump($data);exit;
            $userdata=[
                'pro'=>$data['pro'],
                'cycle'=>$data['cycle'],
                'status'=>$data['status'],
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
            $user = DB::name('admin')->field('id,username')->select();
            $assign=array(
                'data'=>$data,
                'user'=>$user
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
              
               //dump($array);
            }

            $user = DB::name('admin')->field('id,username')->select();//dump($info);
          
      
            $position = db('position')->select();
            // $user = DB::name('admin')->field('id,username')->select();
            $this->assign('position',$position);
            $this->assign('string',$array);
            $this->assign('user',$user);
            $this->assign('data',$data);

            return $this->fetch();
        }
    }

    public function delete(){
          $id = input('id');
            $result = DB::name('project')->where(array('id'=>$id))->update(array('is_delete'=>2));
            if($result){
                echo json_encode(array('status'=>1000,'msg'=>'删除成功!'));
            }else{
                echo json_encode(array('status'=>1001,'msg'=>'删除失败!'));
            }

    }


}
