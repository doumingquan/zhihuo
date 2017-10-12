<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
       return $this->fetch('admin@index/index');
    }
}
