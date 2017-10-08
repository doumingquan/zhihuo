<?php
namespace app\admin\model;
use think\Db;
class Admin extends \think\Model
{
    /*登录验证*/
    public static function change($id, $data)
    {
        $changedata = Db::name('auth_rule')->where($id)->update($data);
        if ($changedata) {
            return true;
        } else {
            return false;
        }
    }


    public function getTree($data)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == 0) {

                $data[$k]['_name'] = $data[$k]['title'];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($v['id'] == $n['pid']) {
                        $data[$m]['_name'] = '|—' . $data[$m]['title'];
                        $arr[] = $data[$m];
                        foreach ($data as $s => $k) {
                            if ($n['id'] == $k['pid']) {
                                $data[$s]['_name'] = '|  |——' . $data[$s]['title'];
                                $arr[] = $data[$s];
                            }
                        }
                    }
                }
            }

        }
        return ($arr);

    }

    public function treedata($items)
    {
        foreach($items as $item)
        $items[$item['pid']]['_data'][$item['id']] = &$items[$item['id']];
    return isset($items[0]['_data']) ? $items[0]['_data'] : array();

    }

    public function diffDate($date1,$date2){ 
        if(strtotime($date1)>strtotime($date2)){ 
            $tmp=$date2; 
            $date2=$date1; 
            $date1=$tmp; 
        } 
            list($Y1,$m1,$d1)=explode('-',$date1); 
            list($Y2,$m2,$d2)=explode('-',$date2); 
            $Y=$Y2-$Y1; 
            $m=$m2-$m1; 
            $d=$d2-$d1; 
        if($d<0){ 
            $d+=(int)date('t',strtotime("-1 month $date2")); 
            $m--; 
        } 
        if($m<0){ 
            $m+=12; 
            $y--; 
        } 
        return array('year'=>$Y,'month'=>$m,'day'=>$d); 
    }
}
