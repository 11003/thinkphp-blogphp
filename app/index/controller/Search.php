<?php
namespace app\index\controller;
use app\index\model\Artlist as Article;
use app\index\model\Cate;
class Search extends Common
{
    public function index()
    {
        $data = trim(input('key'));
        if(isset($data)){
            $this->key($data);
        }
        return view('search');
    }
    public function key($data)
    {
        $join = [
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        $field="a.id,a.title,a.content,a.pic,a.click,a.look,a.create_time,a.cid,c.catename,a.rec";
        $db = db('Article')->alias('a')->field($field)->join($join);
        if(!empty($data)){
            $db->order('a.create_time desc')->where('a.title|a.keywords','LIKE','%'.$data.'%');
        } else {
            $db->order('a.rec_time desc')->where('rec','=',1);
        }
        $serRes = $db->select();
        foreach($serRes as $k=>$v){
            $serRes[$k]['content'] =$this->cutstr_html(urldecode($v['content']),100);
            $serRes[$k]['rec'] = $v['rec']?"1":"";
            $serRes[$k]['create_time'] = date("Y-m-d H:i:s",$v['create_time']);
        }
        $this->assign('data',$data);
        $this->assign('serRes',$serRes);
    }
}
