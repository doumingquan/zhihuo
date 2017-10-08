<?php
namespace app\common\model;
use think\Model;
use think\Validate;
use think\Loader;

class Admin extends Model{
	protected $pk='id';
	protected $table='admin';
	
	public function login($data){
		//halt($data);
		$validate = Loader::validate('Admin');

//验证器验证字段是否为空
		if(!$validate->check($data)){
			return ['status'=>0,'msg'=>$validate->getError()];
		    //dump($validate->getError());
		}

//验证密码是否正确($this指代的是control)；//需要对密码进行加密
		$info=db('admin')->where('username',$data['username'])->where('password',$data['password'])->find();//dump($info);
		//$info=$this->where('admin_name',$data['username'])->where('password',$data['password'])->find();
//halt(info);
		//echo $this->getlastSql();exit;
		if($info){

			session('admin.admin_id',$info['id']);
			session('user',$info);

			return ['status'=>1,'msg'=>'操作成功!'];
		}else{
			return ['status'=>0,'msg'=>'用户名或者密码错误!'];
		}

	}
}


?>