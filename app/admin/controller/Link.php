<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Link as LinkModel;
class Link extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('link');
    }

    public function index()
    {
        $model = new LinkModel();
        if($this->request->isPost()){
            $data = input('post.');
            foreach ($data as $k => $v) {
                $model->update(['id'=>$k,'sort'=>$v]);
            }
            return json(['msg'=>'排序成功！','status'=>1]);
        }
        $res = $model->order('sort ASC')->select();
        $this->assign('res',$res);
        return view('',['title'=>'友情链接']);
    }
    public function add()
    {
        return view('');
    }
    public function addPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
            //验证
            $validate = validate('Link');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $res = $this->db->insert($data);
                if($res){
                    return json(['msg'=>'添加成功！','status'=>1]);
                }else{
                    return json(['msg'=>'添加失败！','status'=>0]);
                }
            }
        }
    }

    public function edit()
    {
        $model = new LinkModel();
        $id = input('id');
        $res = $model->where(['id'=>$id])->find();
        $this->assign(array(
            'res'=>$res,
        ));
        return view();
    }

    public function editPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
            $validate = validate('Link');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $res = $this->db->update($data);
                if($res){
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
        $res = $this->db->where(['id'=>$id])->delete();
        if($res){
            return json(['msg'=>'删除成功！','status'=>1,'url'=>'index']);
        }else{
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }

    public function status()
    {
        $id = input('id');
        $status = input('status');
        if($status == 1){
            //发布
            $this->db->where('id',$id)->setField('status',1);
            return json(['msg'=>'发布成功！','status'=>1]);
        }elseif($status == 0){
            $this->db->where('id',$id)->setField('status',0);
            return json(['msg'=>'取消发布！','status'=>1]);
        }else{
            return json(['msg'=>'发布失败！','status'=>0]);
        }
    }
}
