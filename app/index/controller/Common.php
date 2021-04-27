<?php
namespace app\index\controller;
use think\Controller;
use think\DB;
use app\index\model\Conf;
use app\index\model\Cate;
use app\index\model\Link;
use app\index\model\Artlist;
use think\Request;
class Common extends Controller
{
    protected $_conf = "";

    protected $_type_nav = [
        1 => 'artlist.html?cid=',
        2 => 'about.html?cid=',
        3 => 'timeline.html?cid=',
        4 => '#four'
    ];

    public $_conf_articlePass = "";
	public function _initialize()
	{
		$cid = input('cid');
		$this->Link();//友情链接
		$this->HotRes($cid);//热门文章
		$this->Xue($cid);//面包屑
        $this->getNavCates();//导航栏目
        $this->getConf();//系统配置
        $this->slider();//轮播图
        $this->rec_right();//右侧广告位
        $request = Request::instance();
        $this->assign('request',$request->path());
	}

	public function HotRes($cid,$api = false,$limit = 5)
	{
		//热门文章
		$art = new Artlist();
		$id = input('id');
		if(!empty($id)){
			//热门文章有条件
			$hotres = $art->HotRes_y($cid,$limit);
		}else{
			$hotres = $art->HotRes($limit);
		}
		if ($api === true){
            return json_encode($hotres);
        }
		cache('hotres',$hotres);
		$this->assign('hotres',cache('hotres'));
	}
	//导航栏目
	public function getNavCates($api = false)
	{
		$cate = new Cate();
		$cateres = $cate->where(['pid'=>0])->order('sort desc')->select();

		//找出子栏目
		foreach ($cateres as $k => $v) {
		    // blog导航地址规则

            if($v['catename'] == '邻居') {
                $cateres[$k]['url'] = $this->_type_nav[4];
            } else {
                $cateres[$k]['url'] = $this->_type_nav[$v['type']] . $v['id'];
            }
			$children = $cate->where(['pid'=>$v['id']])->order('sort desc')->select();
			if($children){
				$cateres[$k]['children']=$children;
			}else{
				$cateres[$k]['children']=0;
			}
		}
		if($api === true){
            return json_encode($cateres);
        }
        $this->assign('cateres',$cateres);
		 // dump($cateres);
	}
	//系统配置
	public function getConf($api = false)
	{
		$conf = new Conf();
		$conf_res = $conf->getAllConf();
		$conf_arr = array();
		foreach ($conf_res as $k => $v) {
			//  'comment' => string '允许评论' (length=12)
			$conf_arr[$v['en_name']]=$v['value'];
			// $conf_arr[$v['en_name']]=$v['cn_name'];
		}
		// dump($conf_arr);
		if($conf_arr['close'] == '是'){
			abort(404,'系统出错！');
		}
        $this->_conf_articlePass = $conf_arr['article_pass'];
		unset($conf_arr['article_pass']);
//        $conf_arr['article_pass'] = $conf_arr['article_pass'] ? md5($conf_arr['article_pass'] . config('salt')) : $conf_arr['article_pass'];
        if($api === true){
            return json_encode($conf_arr);
        }
        $this->_conf = $conf_arr;
		$this->assign('confres',$conf_arr);
	}
	//轮播图
	public function slider()
	{
		$imgres = DB::name('img')->limit(4)->field('pic,url,desc')->where(['status'=>1])->select();
		$this->assign('imgres',$imgres);
	}
	//面包屑
	public function Xue($cid)
	{
		$cate = new Cate();
		$xue = $cate->getparents($cid);//面包屑
		$this->assign('xue',$xue);
	}
	//友情链接
	public function Link($api = false)
    {
        $link = Link::where('status',1)->order('sort ASC')->select();
        if($api === true){
            return json_encode($link);
        }
        cache('link',$link);
        $this->assign('link',cache('link'));
    }
    //右侧广告图
    public function rec_right()
    {
        $rec_index = DB::name('admin')->where('id',1)->find();
        $rec_index['url'] = "/page/41";
        $rec_index['desc'] = $rec_index['nickName'];
        cache('arr',$rec_index);
        $this->assign('rec_right',cache('arr'));
    }

    /**
     * 解析 urldeocde 并截取
     * @param $string
     * @param $sublen
     * @return string|string[]|null
     */
    public function cutstr_html($string, $sublen)
    {
        $string = strip_tags($string);
        $string = preg_replace ('/\n/is', '', $string);
        $string = preg_replace ('/ |　/is', '', $string);
        $string = preg_replace ('/&nbsp;/is', '', $string);

        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);
        if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";
        else $string = join('', array_slice($t_string[0], 0, $sublen));

        return $string;
    }
}
