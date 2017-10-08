<?php
namespace app\admin\widget;
use think\Controller;
class Widget extends Controller
{
    public function left()
    {
        return $this->fetch('widget/left');//视图文件
    }
    
}
?>