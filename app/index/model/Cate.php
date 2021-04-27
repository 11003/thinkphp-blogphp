<?php
namespace app\index\model;
use think\Model;
class Cate extends Model
{
	//找出子栏目
    public function getchildrenid($cid){
        $cateres=$this->select();
        if($cateres){
            $arr = $this->_getchildrenid($cateres,$cid);
	        $arr[] = $cid;
            $strId=implode(',',$arr);
            return $strId;  //35,39,36  36是顶级栏目
        }

    }
    public function _getchildrenid($cateres,$cid){
        static $arr=array();
        foreach($cateres as $k=>$v){
            if($v['pid'] == $cid){
                $arr[]=$v['id'];
                //防止无下限循环
                $this->_getchildrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }


    //面包屑
    public function getparents($cid){
        $cateres=$this->field('id,pid,catename')->select();
        $cates = db('cate')->field('id,pid,catename')->find($cid);
        $pid=$cates['pid'];
        if($pid){
            $arr = $this->_getparentsid($cateres,$pid);
        }
        $arr[]=$cates;
        // dump($arr);
        return $arr;

    }
    public function _getparentsid($cateres,$pid){
        static $arr=array();
        foreach($cateres as $k=>$v){
            if($v['id'] == $pid){
                $arr[]=$v;
                //防止无下限循环
                $this->_getparentsid($cateres,$v['pid']);
            }
        }
        return $arr;
    }
}