<?php
namespace app\index\controller;
use app\index\model\Artlist as Article;
use app\index\model\Cate;
class Artlist extends Common
{
    public function index()
    {
    	$cid = input('cid');
        $article = new Article();
        $join = [
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        $field="a.id,a.title,a.rec,a.content,a.pic,a.click,a.look,a.create_time,a.cid,c.catename,c.pid";
        //where('pid',$cid) 找出子栏目
        //where('cid',$cid) 找出自栏目
    	$artRes =db('article')->alias('a')->field($field)->join($join)->order('rec desc,create_time desc')->where('pid',$cid)->paginate(8);
    	if(count($artRes) == 0){
            $artRes =db('article')->alias('a')->field($field)->join($join)->order('rec desc,create_time desc')->where('cid',$cid)->paginate(8);
        }
        $arr= array();
     

        foreach($artRes as $k=>$v){
           $v['content'] =$this->cutstr_html(urldecode($v['content']),100);
           $v['create_time'] = date("Y-m-d H:i:s",$v['create_time']);
           $v['rec'] = $v['rec']?"1":"";
           $arr[]=$v;
        }
        $page = $artRes->render();
    	$artCount = $article->getAllCount($cid);
        cache('artRes',$arr);
    	$this->assign(array(
			'artres'   =>cache('artRes'),
			'artcount' =>$artCount,
            'page'     =>$page,
    	));
        return view('artlist');
    }
  
  public function urlencode_ch($url)
  {
      $pregstr = "/[\x{4e00}-\x{9fa5}]+/u";//中文正则
      if (preg_match_all($pregstr, $url, $matchArray)) {
          foreach ($matchArray[0] as $key => $val) {
              $url = str_replace($val, urlencode($val), $url);//将转译替换中文
          }
          if (strpos($url, ' ')) {//若存在空格
              $url = str_replace(' ', '%20', $url);
          }
      }
      return $url;
  }

}
