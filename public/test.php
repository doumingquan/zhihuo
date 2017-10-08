<?php
function Tree($items){  
    $tree = array();  
    foreach($items as $item){  
        if(isset($items[$item['pid']])){  
            $items[$item['pid']]['son'][] = &$items[$item['id']];  
        }else{  
            $tree[] = &$items[$item['id']];  
        }  
    }  
    return $tree;  
} 


$items = array(  
    1 => array('id' => 1, 'pid' => 0, 'name' => '安徽省'),  
    2 => array('id' => 2, 'pid' => 0, 'name' => '浙江省'),  
    3 => array('id' => 3, 'pid' => 1, 'name' => '合肥市'),  
    4 => array('id' => 4, 'pid' => 3, 'name' => '长丰县'),  
    5 => array('id' => 5, 'pid' => 1, 'name' => '安庆市'),  
);  
print_r(Tree($items)); 

?>
