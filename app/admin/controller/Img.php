<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Img as ImgModel;
class Img extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('img');
    }

    public function index()
    {
        $model = new ImgModel();
        if($this->request->isPost()){
            $data = input('post.');
            foreach ($data as $k => $v) {
                $this->db->update(['id'=>$k,'sort'=>$v]);
            }
            return json(['msg'=>'排序更新成功！','status'=>1]);
        }
        $res = $model->selects();
        $this->assign('res',$res);
        return view('',['title'=>'轮播图']);
    }
    public function add()
    {
        return view();
    }
    public function addPost()
    {
        if($this->request->isAjax()){
            $model = new ImgModel();
            $data = $this->request->param();
            $validate = validate('Img');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
	            $res = $model->save($data);
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
        $id = input('id');
        $res = $this->db->where('id',$id)->find();
        $this->assign(array(
            'res'=>$res,
        ));
        return view();
    }
    public function editPost()
    {
        if($this->request->isPost()){
            $model = new ImgModel();
            $data = $this->request->param();
            $validate = validate('Img');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }else{
                $res = $model->update($data);
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
        $model = new ImgModel();
        $res = $model->destroy($id);
        if($res){
            return json(['msg'=>'删除成功！','status'=>1,'url'=>'index']);
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
            $res = ImgModel::destroy($ids);
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
