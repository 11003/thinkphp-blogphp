<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Article as ArticleModel;
use app\admin\server\UnlimitTree;
class Article extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('article');
    }

    public function index($api = false)
    {
        $model = new ArticleModel();
        $key = filter_Emoji(trim(input('keywords')));

        $search_res=$model->keySelect($key);

        foreach($search_res as $k=>$v){
            $search_res[$k]['unlimit_desc'] = $v['desc'];
            $search_res[$k]['desc'] = subtext($v['desc'],50);
//            if($v['pic']) {
//                $path = parse_url($v['pic']);
//                $search_res[$k]['pic'] = $path['path'];
//            }

        }
        if($api) {
            return $search_res;
        }
        $this->assign([
            'res' => $search_res,
            'keywords' => $key
        ]);

        return view('',['title'=>'文章']);
    }
    public function add()
    {
        $pid = (new UnlimitTree())->catetree('cate');
        $this->assign('pid',$pid);
        return view();
    }
    public function addPost()
    {
        if($this->request->isPost()){
            $art = new ArticleModel();
            $data = $this->request->param();
            $validate = validate('Article');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $data['update_time'] = $data['create_time']=time();
                $data['editor_html_code'] = $data['content'];//makedown语法
                $data['content'] =$data['test-editor-html-code'];//html源代码
                unset($data['test-editor-html-code']);
                $data['keywords']=str_replace("，", ",", $data['keywords']);
                $res = $art->save($data);
                if($res){

//                    Log::write(session('username') . "添加了文章：" . $data['title']);

                    return json(['msg'=>'添加成功！','status'=>1]);
                }else{
                    return json(['msg'=>'添加失败！','status'=>0]);
                }
            }
        }
    }
    public function edit()
    {
        $pid = (new UnlimitTree())->catetree('cate');
        $id = input('id');
        $res = $this->db->where('id',$id)->find();
        $this->assign(array(
            'res'=>$res,
            'pid'=>$pid
        ));
        return view();
    }
    public function editPost()
    {
        if($this->request->isPost()){
            $art = new ArticleModel();
            $data = $this->request->param();
            $validate = validate('Article');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }else{
                $data['editor_html_code'] = $data['content'];//makedown语法
                $data['content'] =$data['test-editor-html-code'];//html源代码
                unset($data['test-editor-html-code']);
                $data['keywords']=str_replace('，',',',$data['keywords']);
                $data['update_time']=time();
                $res = $art->update($data);
                if($res){

//                    Log::write(session('username') . "修改了文章（ID:". $data['id'] ."）：" . $data['title']);

                    return json(['msg'=>'修改成功！','status'=>1]);
                }else{
                    return json(['msg'=>'修改失败！','status'=>0]);
                }
            }
        }
    }
    public function delete()
    {
        $id = input('id');
        $art = new ArticleModel();
        $data = $this->getArticleInfoById($id);
        $res = $art->destroy($id);
        if($res){

//            Log::write(session('username') . "删除了文章：" . $data['title']);

            return json(['msg'=>'删除成功！','status'=>1,'del_url'=>$data['del_url']]);
        }else{
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }
    public function dels()
    {
        $ids = input('post.id/a');
        if(empty($ids)){
            $this->error('未选中任何内容！');
        }
        if($ids){
            $res = ArticleModel::destroy($ids);
            if($res){
                $this->success('删除成功！');
            }else{
                $this->error('删除失败！');
            }
        }
    }
    public function status()
    {
        $id = input('id');
        $rec = input('rec');
        $desc = input('desc');

        $title = $this->getArticleInfoById($id)['title'];
        if($rec == 1){
            //发布
            $data = [
                'rec' => 1,
                'desc' => $desc,
                'rec_time' => time()
            ];
            $this->db->where('id',$id)->update($data);
            return json(['msg'=>$title.' 推荐成功！','status'=>1]);
        }elseif($rec == 0){
            $data = [
                'rec' => 0,
                'desc' =>  '',
                'rec_time' => 0
            ];
            $this->db->where('id',$id)->update($data);
            return json(['msg'=> $title.' 取消推荐！','status'=>1]);
        }else{
            return json(['msg'=>$title.' 推荐失败！','status'=>0]);
        }
    }

    public function mdPass()
    {
        $id = input('id');
        $data = $this->getArticleInfoById($id);
        if($data['is_md'] == 1) {
            $this->db->where('id',$id)->update(['is_md'=>0]);
            return json(['msg'=>'取消加密！','status'=>1]);
        } else {
            $this->db->where('id',$id)->update(['is_md'=>1]);
            return json(['msg'=>'加密成功！','status'=>1]);
        }
    }

    private function getArticleInfoById($id)
    {
        return $this->db->field('title,del_url,is_md')->where(['id'=>$id])->find();
    }
}
