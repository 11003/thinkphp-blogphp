<?php
namespace app\admin\controller;
use League\HTMLToMarkdown\HtmlConverter;
use Parsedown;
use think\Db;
use app\admin\model\Timeline as TimelineModel;
class Timeline extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('timeline');
    }
    public function index()
    {
        $model = new TimelineModel();

        $key = filter_Emoji(trim(input('keywords')));

        $map = [];

        if(!empty($key)) {
            $map['title|content']=['like','%'.$key.'%'];
        }

        $res = $model->order('create_time desc,id desc')->where($map)->select();

        foreach ($res as $k=>$v) {
            $res[$k]['content'] = subtext(strip_tags($v['content']),150);
        }
        $this->assign('res',$res);
        $this->assign('keywords',$key);

        return view('',['title'=>'时间轴']);
    }
    public function add()
    {
        return view();
    }
    public function addPost()
    {
        if($this->request->isPost()){

            $Parsedown = new Parsedown();

            $data = $this->request->param();
            $validate = validate('Timeline');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $data['content'] = $Parsedown->text($data['content']);
                $data['create_time']=time();
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
        $converter = new HtmlConverter();

        $id = input('id');
        $res = $this->db->where(['id'=>$id])->find();

        $res['content'] = $converter->convert($res['content']);

        $this->assign('res',$res);

        return view();
    }

    public function editPost()
    {
        if($this->request->isPost()){

            $Parsedown = new Parsedown();

            $data = $this->request->param();
            $validate = validate('Timeline');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{

                $data['content'] = $Parsedown->text($data['content']);
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
            return json(['msg'=>'删除成功！','status'=>1]);
        }else{
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }
    public function dels()
    {
        $ids = input('id/a');

        if(empty($ids)){
            $this->error('未选中任何内容！');
        }else{
            $ids = implode(",",$ids);
            TimelineModel::destroy($ids);
            $this->success('删除成功！');
        }
    }

    public function status()
    {
        $id = input('id');
        $status = input('status');

        $res = $this->db->where('id',$id)->setField('status',$status);

        $msg = [
            1 => '显示',
            0 => '隐藏'
        ];

        if($res) {
            return json(['msg'=> '该时间轴已'.$msg[$status],'status'=> 1]);
        } else {
            return json(['msg'=> '修改失败！','status'=> 0]);
        }
    }
}
