<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;
use app\admin\model\Comment as CommentModel;
class Comment extends Base
{
    private $db;
    private $reply_db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('comment');
        $this->reply_db = DB::name('reply');
    }

	public function index()
	{
		$model = new CommentModel();
        $key = filter_Emoji(input('keywords'));
        $map = [];
        if($key) {
            $map['user_name|user_comment']=['like','%'.$key.'%'];
        }
		$res = $model->order('create_time desc')->where($map)->paginate(10);
		foreach ($res as $k=>$v) {
            $res[$k]['user_email'] = strip_tags($v['user_email']);
            $res[$k]['un_user_comment'] = strip_tags($v['user_comment']);
            $res[$k]['user_comment'] = subtext($v['user_comment'],50);
        }
		$page= $res->render();
		$this->assign(array(
			'res'=>$res,
			'keywords'=>$key,
			'page'=>$page
		));
		return view('',['title'=>'评论管理']);
	}
	public function edit()
    {
        $model = new CommentModel();
        $id = input('id');
        $res = $model->where(['id'=>$id])->find();
        $res['img_user_comment'] = isIncludedImg('[图片]',$res['user_comment']);
        $res['user_name'] = urldecode($res['user_name']);
        $replyres = $this->reply_db->where('mid='.$id)->select();
        foreach ($replyres as $k =>$v){
            $replyres[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }
        $this->assign(array(
            'res'=>$res,
            'replyres' => $replyres
        ));
        return view();
    }
    public function reply($id)
    {
        $res = $this->reply_db->where('id',$id)->find();
        $res['content'] = htmlspecialchars($res['content']);
        $this->assign('res',$res);
        return view('comment/replyedit');
    }
    public function replyeditPost()
    {
        $data = $this->request->param();
        $data['content']=strip_tags($data['content']);
        $data['create_time']=time();
        $res = $this->reply_db->update($data);
        if($res){
            return json(['msg'=>'修改回复成功！','status'=>1]);
        }else{
            return json(['msg'=>'修改回复失败！','status'=>0]);
        }
    }
    public function replydel()
    {
        $id = intval(input('id'));
        $res = $this->reply_db->where('id',$id)->delete();
        if($res){
            return json(['msg'=>'删除回复成功！','status'=>1]);
        }else{
            return json(['msg'=>'删除回复失败！','status'=>0]);
        }
    }
    public function replyPost()
    {
        if($this->request->isPost()){
            $data = [
                'content' => strip_tags(input('content')),
                'create_time' => input('create_time'),
                'mid' => input('mid')
            ];
            $validate = new Validate([
                'content' => 'require'
            ]);
            $validate->message([
                'content.require' =>'评论不能为空！'
            ]);
            $cid = intval(input('cid'));
            $aid = intval(input('aid'));
            $send_email = 1;
            $user_name = input('user_name');
            $user_email = urldecode(input('user_email'));
            $user_comment = urldecode(input('user_comment'));

            if($send_email==1 && !empty($send_email)){
                $title['title'] = DB::name('article')->field('title')->where(['id'=>$aid])->find();
                if($cid){
                    $str_title = "关于我";
                }else{
                    $str_title = $title['title'] ? implode('', $title['title']) : "此文章可能被删除了...";
                }
                send_email($user_email,$cid,$aid,$str_title,$data['content'],$user_name,$user_comment);
            }
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $nickName = $this->adminInfo()['nickName'];
                $data['create_time'] = time();
                $data['reply_name'] = $nickName;
                $data['uName'] = $user_name;
                $data['uid'] = 1;
                $res = $this->reply_db->insert($data);
                if($res){
                    return json(['msg'=>'回复成功！','status'=>1]);
                }else{
                    return json(['msg'=>'回复失败！','status'=>0]);
                }
            }
        }
    }
    public function delete()
    {
        $id = input('id');
        $res = $this->db->where(['id'=>$id])->delete();
        if($res){
            //顺带删除我的回复
            $this->reply_db->where(['mid'=>$id])->delete();
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
            return json(['msg'=>'禁止成功！','status'=>1]);
        }else{
            return json(['msg'=>'发布失败！','status'=>0]);
        }
    }

    public function dels()
    {
        $ids = input('id/a');

        if(empty($ids)){
            $this->error('未选中任何内容！');
        }else{
            $ids = implode(",",$ids);
            CommentModel::destroy($ids);
            $this->success('删除成功！');
        }
    }
}
