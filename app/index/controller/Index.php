<?php
namespace app\index\controller;
use think\DB;
use app\index\model\Artlist;
class Index extends Common
{
    public function index()
    {
        if($this->_conf['old_index'] == '是') {
            $artres=$this->Alist();//文章列表
            cache('artres',$artres);
            $this->assign('artres',cache('artres'));
            $this->rec_index();
            return view('old_index');
        } else {
            $res = DB::name('admin')->where('id=1')->field('desc,pic,nickName,info')->find();
            $res['info'] = json_decode($res['info'],true);
            $res['holiday_info'] = $this->getHoliday()['tts'];
            $this->assign('res',$res);
            return view();
        }
    }

    private function getHoliday() {
        $data = file_get_contents('http://timor.tech/api/holiday/tts');
        return json_decode($data,true);
    }

    public function resume()
    {
        $res = DB::name('cate')->where(['catename'=>'简历'])->field('content,keywords')->find();
        $this->assign('res',$res);
        return view();
    }
    public function Alist($api = false)
    {
        $art = new Artlist();
        $join = [
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        $field="a.id,a.title,a.content,a.desc,a.pic,a.click,a.look,a.create_time,a.cid,c.catename,a.rec";
        $artres = $art->alias('a')->field($field)->join($join)->order('rec desc,create_time desc')->paginate(9);
        $arr = array();
		foreach($artres as $k => $v){
            $v['content'] =$this->cutstr_html(urldecode($v['content']),100);
            $v['rec'] = $v['rec']?"1":"";
            $v['url'] = 'post.html?id='.$v['id'];
            $arr[]=$v;
        }
		if($api){
		    return json_encode($artres);
        }
        //把缓存的结果存在redis里面去
        return $artres;

    }
    //轮播图位置
    private function rec_index()
    {
        $rec_index = DB::name('img')->limit(1)->where(['status'=>1,'rec_index'=>1])->find();
        $this->assign('rec_index',$rec_index);
    }
}
