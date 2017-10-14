<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::rule('search/[:keywords]','Search/index','GET|POST');
Route::rule('index','admin/index/index');
Route::rule('staff_index','admin/staff/index');
Route::rule('my_center','admin/staff/my_center');
//修改密码
Route::rule('password_msg','admin/staff/password_msg');
Route::rule('my_salary','admin/staff/my_salary');
Route::rule('ad_list','admin/admin/ad_list');
Route::rule('ad_index','admin/admin/index');
Route::rule('check_index','admin/admin/check_index');
Route::rule('user_pay','admin/admin/user_pay');
Route::rule('add_user','admin/user/add_user');
Route::rule('project_index','admin/project/index');
Route::rule('project_add','admin/project/add');
Route::rule('rule_list','admin/Rule/rule_list');
Route::rule('rule_group','admin/Rule/rule_group');
Route::rule('user_index','admin/User/index');
/*Route::rule('company_index','admin/company/index');*/
Route::rule('depart_list','admin/depart/depart_list');
Route::rule('position_list','admin/position/position_list');
Route::rule('depart_list','admin/depart/depart_list');
Route::rule('change_msg','admin/Staff/change_msg');

/*Route::rule('rule_distribution/:id','admin/rule/rule_distribution','GET',['ext'=>'html'],['id'=>'\d{1,5}']);*/
