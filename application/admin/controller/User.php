<?php
namespace app\admin\controller;
use app\common\controller\Adminbase;
use think\Db;
use think\Request;
/**
 * 后台首页控制器
 */
class User extends Adminbase{

	/**
	 * 用户列表
	 */
	public function index(){
		
		$data=Db::name('auth_group_access')
            ->alias('aga')
            ->field('u.id,u.username,u.email,aga.group_id,ag.title')
            ->join('__ADMIN__ u' , 'aga.uid=u.id','RIGHT')
            ->join('__AUTH_GROUP__ ag' , 'aga.group_id=ag.id','LEFT')
            ->select();
        $first=$data[0];
       // dump($data);
        $first['title']=array();
        $user_data[$first['id']]=$first;
        // 组合数组
        foreach ($data as $k => $v) {
            foreach ($user_data as $m => $n) {
                $uids=array_map(function($a){return $a['id'];}, $user_data);
                if (!in_array($v['id'], $uids)) {
                    $v['title']=array();
                    $user_data[$v['id']]=$v;
                }
            }
        }
        // 组合管理员title数组
        foreach ($user_data as $k => $v) {
            foreach ($data as $m => $n) {
                if ($n['id']==$k) {
                    $user_data[$k]['title'][]=$n['title'];
                }
            }
            $user_data[$k]['title']=implode('、', $user_data[$k]['title']);
        }
            
        $assign=array(
            'data'=>$user_data
            );
        $this->assign($assign);
        return $this->fetch();
	}

    /**
     * 添加管理员
     */
    public function add_user(){
        if(Request::instance()->post()){
            $data=input('post.');
           //halt($data);
            $userdata=[
                'username'=>$data['username'],
                'mobile'=>$data['phone'],
                'password'=>md5($data['password']),
                'status'=>$data['status'],
                'company_id'=>$data['company_id']

            ];
            //dump($userdata);exit;
            $result=Db::name('admin')->insert($userdata);
            $datagroup=Db::name('admin')->where(['username'=>$data['username']])->find();
            if($result){
                if (!empty($data['group_ids'])) {
                    foreach ($data['group_ids'] as $k => $v) {
                        $group=array(
                            'uid'=>$datagroup['id'],
                            'group_id'=>$v
                            );
                        Db::name('auth_group_access')->insert($group);
                    }                   
                }
                // 操作成功
                $this->success('添加成功','Admin/User/index');
            }else{
                $this->error('修改失败');
            }
        }else{
            $data=Db::name('auth_group')->select();
            $info = Db::name('company')->where()->select();//dump($info);
            $assign=array(
                'data'=>$data,
                'info'=>$info
                );
            $this->assign($assign);
            return $this->fetch();
        }
    }


    /**
     * 修改管理员
     */
    public function edit_user($id){
        if(Request::instance()->post()){
            $data=input('post.');
            if($data['password']!=''){               
                $data['password']=md5($data['password']);
            }

            Db::name('auth_group_access')->where(array('uid'=>$id))->delete();
            if (!empty($data['group_ids'])) {
                foreach ($data['group_ids'] as $k => $v) {
                    $group=[
                        'uid'=>$id,
                        'group_id'=>$v
                       ];
                    Db::name('auth_group_access')->insert($group);
                }
            }
            // $data=array_filter($data);
            // 如果修改密码则md5
            // p($data);die;
            // if ($data['password']!=null) {
             //   $userup['password']=md5($data['password']);
            // }
            $userup=[
                'password'=>$data['password'],
                'username'=>$data['username'],
                'mobile'=>$data['phone'],
                'email'=>$data['email'],
                'status'=>$data['status'],

            ];

            $results=Db::name('admin')->where(['id'=>$id])->find();
            $result=Db::name('admin')->where(['id'=>$id])->update($userup);
            // trace("****************************************************************************");
            // trace($userup);
            // trace($results);
            // trace($result);
            // trace("****************************************************************************");
            if($result){
                // 操作成功
                $this->success('编辑成功','Admin/User/index');
            }else{
                $this->error('修改失败');
            }
        }else{
        	if(Request::instance()->get()){
        		 $id=input('get.id',0,'intval');
        	}
          
            // 获取用户数据
            $user_data=Db::name('admin')->where(array('id'=>$id))->find();//dump($user_data);
            // 获取已加入用户组
            $group_data=Db::name('auth_group_access')
                ->where(array('uid'=>$id))
                ->find();
            // 全部用户组
            $data=Db::name('auth_group')->select();
            $assign=array(
                'data'=>$data,
                'user_data'=>$user_data,
                'group_data'=>$group_data['group_id']
                );
            $this->assign($assign);
            return $this->fetch();
        }
    }


    /*个人中心*/    /*分开写是为了将权限更细化*/
    // public function my_center(){
    //     return $this->fetch();
    // }

    /*修改个人资料*/
    // public function change_msg(){
    //     if(Request::instance()->post()){
    //         $data['username']  =  trim(input('post.username'));
    //         $data['email']  =  trim(input('post.email'));
    //         $data['phone']=trim(input('post.phone'));
    //         $map=array(
    //             'username'=>session('user')['username']
    //             );
    //         if (!empty(input('post.password'))) {
    //             $data['password']=md5(input('post.password'));
    //         }
    //         $result=Db::name('users')->where($map)->update($data);

    //         if($result){
    //             // 操作成功
    //             session('user',null);
    //             $this->success('退出成功、前往登录页面','Home/Index/index');
    //         }else{
    //             $this->error("您没有做任何修改");   
    //         }
    //     }
    // }


}
