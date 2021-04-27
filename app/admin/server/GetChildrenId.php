<?php
/**
 * User: Lh
 * Date: 2019/4/24 22:04
 */

namespace app\admin\server;


use app\admin\controller\Base;

class GetChildrenId extends Base
{
    /**
     * 找出它的儿子
     */
    public function getchildrenid($table,$cid){
        $table_res=db($table)->select();
        if($table_res){
            return $this->_getchildrenid($table_res,$cid);
        }
    }
    private function _getchildrenid($table_res,$cid){
        static $arr=array();
        foreach($table_res as $k=>$v){
            if($v['pid'] == $cid){
                $arr[]=$v['id'];
                //防止无下限循环
                $this->_getchildrenid($table_res,$v['id']);
            }
        }
        return $arr;
    }
}