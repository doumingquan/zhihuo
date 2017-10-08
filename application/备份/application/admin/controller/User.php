<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
		echo 123;
        return $this->fetch();
    }
}
