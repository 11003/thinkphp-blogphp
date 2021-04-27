<?php
namespace app\index\controller;
use app\index\model\Artlist as Article;
use app\index\model\Cate;
use think\DB;
class Imglist extends Common
{
	public function index()
	{
		$res = DB::name('Article')->select();
		cache('res',$res);
        $this->assign('res',cache('res'));
		return view('imglist');
	}
}