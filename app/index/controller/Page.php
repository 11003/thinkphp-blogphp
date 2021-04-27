<?php
namespace app\index\controller;
use think\DB;
use app\index\model\Artlist;
use app\index\model\Cate;
class Page extends Common
{
	public function index()
	{
		$cid = input('cid');
		$cate = new Cate();
		$res = $cate->where(['type'=>2,'pid'=>0,'id'=>$cid])->find();
		if($res['catename'] == "邻居"){
		    $res['link'] = db("link")->order('sort ASC')->where('status',1)->select();
        }
		$this->assign('res',$res);
		return view('page');
	}
}