<?php
namespace app\index\model;
use think\Model;
class Conf extends Model
{
	public function conf()
	{
		$conf_res = $this->getAllConf();
		$conf_arr = array();
		foreach ($conf_res as $k => $v) {
			//  'comment' => string '允许评论' (length=12)
			$conf_arr[$v['en_name']]=$v['value'];
			// $conf_arr[$v['en_name']]=$v['cn_name'];
		}
		if($conf_arr['close'] == '是'){
			abort(404,'系统出错！');
		}
		return $conf_arr;
	}
	public function getAllConf()
	{
		return $this->field('en_name,cn_name,value')->select();
	}
}