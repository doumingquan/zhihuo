<?php
namespace app\admin\widget;
use think\Controller;
class Widgets extends Controller
{
    public function leftcaidan()
    {
        return $this->fetch('widget/leftcaidan');//视图文件
    }
    
}
?>