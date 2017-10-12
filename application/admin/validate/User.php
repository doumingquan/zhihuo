<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule=[
        'username'   => 'require|max:25|unique:admin',
        'password' =>  'require',
    ];

    protected $message=[
        'username.require' => '账号必须填写',
        'username.max' => '账号长度不得大于25位',
        'username.unique' => '账号名称不得重复',
        'password.require' => '账号密码必须填写',
    ];

    protected $scene=[
        'add'  =>  ['username'=>'require|unique:admin','password'],
        'edit'  =>  ['username'=>'require|unique:admin'],
    ];

}