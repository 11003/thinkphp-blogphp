<?php
/**
 * User: Lh
 * Date: 2019/4/24 21:57
 */

namespace app\admin\server;

use app\admin\controller\Base;
use think\Db;

class UnlimitTree extends Base
{
    //无限级分类
    public function catetree($table = 'cate',$is_need = FALSE)
    {
        $data = DB::name($table)->order('sort desc')->select();

        if($is_need){
            return $this->auth_resort($data);
        } else {
            return $this->resort($data);
        }
    }

    /**
     * 栏目的无限极
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     * 使用静态变量有限制：如果一次请求调用两次来实现2个无限级分类就会出现问题，但我们这里一个类只调用了一次
     */
    private function resort($data,$pid = 0,$level = 0)
    {
        static $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->resort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }


    /**
     * 栏目的无限极
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    private function infiniteSort($data,$pid = 0,$level = 0)
    {
        $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                unset($data[$k]);
                $tempArr = $this->resort($data,$v['id'],$level+1);
                if(!empty($tempArr)){
                    $arr = array_merge($arr, $tempArr);
                }
            }
        }
        return $arr;
    }
    /**
     * 权限的无限极
     * @param $data
     * @param int $pid
     * @return array
     */
    private function auth_resort($data,$pid = 0)
    {
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){
                $v['dataid']=$this->getparentAuthid($v['id']);
                $arr[]=$v;
                $this->auth_resort($data,$v['id']);
            }
        }
        return $arr;
    }

    /**
     * 配置权限
     */
    private function getparentAuthid($authRuleId){
        $AuthRuleRes=db('auth_rule')->select();
        return $this->_getparentAuthid($AuthRuleRes,$authRuleId,TRUE);
    }

    private function _getparentAuthid($AuthRuleRes,$authRuleId,$clear=FALSE){
        static $arr=array();
        if($clear){
            $arr=array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if($v['id'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getparentAuthid($AuthRuleRes,$v['pid'],FALSE);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }
}
