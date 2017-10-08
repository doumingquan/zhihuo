<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25',
        'password' =>  'require',
       
    ];

    protected $message = [
    	'username.require' => '请输入用户名',
    	'password.require' => '请输入密码',
    ];


}