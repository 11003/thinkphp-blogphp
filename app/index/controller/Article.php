<?php
namespace app\index\controller;
use think\DB;
use think\Image;
use think\Session;
use think\Validate;

class Article extends Common
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('Article');
    }
    public function index()
    {
    	$cid = input('cid');
    	$id = input('id');
        $this->find($id,$cid);
        $this->rec($cid,$id);//推荐的文章
        $this->setIncArt();
        $this->adminName();//管理员姓名
        $this->commentIndex($cid,$id);//评论列表
        $this->PervAndNext($cid,$id);//上一篇和下一篇
        return view('article');
    }
    public function setIncArt()
    {
        $id = intval(input('id'));
        $this->db->where('id',$id)->setInc('look');
    }
    public function like()
    {

        $cid = input('cid');
        $aid = input('aid');
        // 今天内的点赞超过1000就停止点赞
        $stop = $this->db->whereTime('like_time','d')->where(['id'=>$aid,'cid'=>$cid])->find();
        if($stop['click'] > 1000){
            return json(['msg'=>'系统检测到异常，点赞失败！感谢您的支持~','status'=>0]);
        }

    	if($this->request->isPost()){
            $this->db->where(['id'=>$aid,'cid'=>$cid])->setInc('click', 1);
            $this->db->where(['id'=>$aid,'cid'=>$cid])->update(['like_time'=>time()]);

            return json(['msg'=>'点赞成功！感谢您的支持。','status'=>1]);
    	}
    }

    //评论逻辑
    public function comment()
    {
        if($this->request->isPost()){
            $validate = new Validate([
                'user_name'=>'require|min:2|max:6',
                'user_email'=>'require|email',
                'user_comment'=>'require',
                'link' => 'url'
            ]);
            $validate->message([
                'user_name.require' => '用户名不能为空!~',
                'user_name.min' => '用户名最少2个字符',
                'user_name.max' => '用户名最大6个字符',
                'user_email.require' =>'用户邮箱不能为空,绝对保密',
                'user_email'    => '邮箱格式错误！',
                'user_comment.require' =>'评论不能为空哦~',
                'link.url' =>'网站格式错！',
            ]);
            $data = input('post.');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }else{
                $data['create_time']=time();
                $data['ip']=get_client_ip();
                $data['user_comment']=(string_remove_xss($data['user_comment']));
                $data['user_name']=string_remove_xss($data['user_name']);
                $data['link']=string_remove_xss($data['link']);
                $res = DB::name('comment')->insert($data);
                if($res){
                    session('user_name',$data['user_name']);
                    session('user_email',$data['user_email']);
                    session('user_link',$data['link']);
                    isset($data['send_email'])?session('send_email',$data['send_email']):0;
                    return json(['msg'=>'评论成功！感谢您的支持。','status'=>1]);
                }else{
                    return json(['msg'=>'评论失败！','status'=>0]);
                }
            }
        }else{
            abort(404,'页面不存在');
        }
    }
    public function reply()
    {
        if($this->request->isPost()){
            $data = input('post.');
            $pam = strpos($data['content'],config('reply_rule'));
            $validate = new Validate([
                'content'=>'require|min:2|max:250',
            ]);
            $validate->message([
                'content.require' => '回复TA的内容不能为空',
                'content.min' => '回复内容最少2个字符',
                'content.max' => '回复内容最大250个字符',
            ]);
            $data['create_time']=time();
            $data['ip']=get_client_ip();

            if($pam !== false){
                $adminName = DB::name('admin')->where('id',1)->find();
                $reply_name = $adminName['nickName'];
                $data['uid'] = $adminName['id'];
                $c = explode(config('reply_rule'),$data['content']);
                $content = $c[1];
            }else{
                $session = Session::has('user_name');
                if(!$session){
                    return json(['msg'=>'请填写留言信息后再来回复'.$data['uName'].'吧！','status'=>0]);
                }
                $reply_name = session('user_name');
                $content = (string_remove_xss($data['content']));//编码格式
            }
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }else{
                $data['reply_name']= $reply_name;
                $data['content']= $content;//编码格式

                $res = DB::name('reply')->insert($data);
                if($res){
                    return json(['msg'=>'','status'=>1]);
                }else{
                    return json(['msg'=>'回复失败！','status'=>0]);
                }
            }


        }else{
            abort(404,'页面不存在');
        }
    }
    //评论列表
    public function commentIndex($cid,$id,$api = false)
    {
//        此条评论因作者被系统屏蔽而不显示
        $res = DB::name('comment')->where(['aid'=>$id,'cid'=>$cid])->order('create_time desc')->select();
        foreach ($res as $k=>$v){
            if($v['status'] != 1){
                $res[$k]['user_comment'] = '<span style="color:#666 !important;display: block;">此条评论因被作者屏蔽而不显示</span>';
            }
        }
        $reply = $this->replyIndex();
        if($api){
            $c = db('comment')->where(['aid' => $id])->order('create_time DESC')->select();
            foreach ($c as $k => $v){
                $c[$k]['date_create_time'] = date("Y-m-d H:i:s", $c[$k]['create_time']);
                $c[$k]['create_time'] = transfer_time($v['create_time']);
                if($v['status'] != 1){
                    $c[$k]['user_comment'] = '<span style="color:#999;display:block;cursor:help">此条评论因被作者屏蔽而不显示</span>';
                }
            }
            return $c;
        }
        cache('comment',$res);
        cache('reply',$reply);
        $this->assign('comment',cache('comment'));
        $this->assign('reply',cache('reply'));
    }
    public function replyIndex()
    {
        $reply = DB::name('reply')->alias('r')->join('comment c','c.id=r.mid')->field('c.user_name,r.*')->select();
        return $reply;

    }
    public function find($id,$cid,$api = false)
    {
        $res = $this->db->where(['id'=>$id])->find();
        if($res == ''){
            return json_encode(['code'=>404,'msg'=>'页面不存在']);
//            abort(404,'页面不存在');
        }

        //  把 src 改为 data-src
        $data_img = img_lazy($res['content']);
        $res['content'] = $data_img;
        unset($res['editor_html_code']);
        $res['create_time'] = transfer_time($res['create_time']);
        $res['look'] = LookNumbers($res['look']);
        $comment_count = DB::name('comment')->where('aid',$id)->count('id');
        if($api){
            $res['keywords'] = $res['keywords'] ? explode(",",$res['keywords']) : "";
            $res['catename'] = $this->cate_name($res['cid']);
            return json_encode($res);
        }else{
            cache('res',$res);
            cache('comment_count',$comment_count);
            $this->assign([
                'res' => cache('res'),
                'comment_count' => $comment_count ? cache('comment_count')."条" : ""
            ]);
        }
    }
    private function cate_name($id)
    {
        $cate_name = DB::name('cate')->where('id',$id)->field('catename')->find()['catename'];
        return $cate_name;
    }
    public function rec($cid,$id,$isIndex,$api = false)
    {
        $DB = DB::name('article')->alias('a');
        $where['a.cid'] = ['eq',$cid];
        $where['a.id'] = ['neq',$id];
        if($isIndex === 'undefined'||$isIndex==='false') {
            $join = [['__CATE__ c','c.id=a.cid','LEFT']];
            $lists = $DB->orderRaw('rand()')->where('a.id','neq', $id)->where('c.pid','eq',$cid)->field('a.title,a.id,a.create_time,a.cid')->join($join)->order(['a.click'=>'DESC','a.create_time'=>'DESC','a.look'=>'DESC'])->limit(10)->select();
            if(empty($lists)) {
                $lists = $DB->orderRaw('rand()')->where('id','neq', $id)->where('cid','eq',$cid)->field('title,id,create_time,cid')->order(['click'=>'DESC','create_time'=>'DESC','look'=>'DESC'])->limit(10)->select();
            }
        } else {
            $lists = $DB->orderRaw('rand()')->field('a.create_time,a.id,a.cid,a.title')->where($where)->order(['a.click'=>'DESC','a.create_time'=>'DESC','a.look'=>'DESC'])->limit(10)->select();
        }
        foreach ($lists as $k => $v) {
            $lists[$k]['create_time'] = "发表于" .date("Y-m-d H:i:s",$v['create_time']);
        }
        cache('lists',$lists);
        if($api) {
            return json_encode($lists);
        }
        $this->assign('rec',cache('lists'));
    }
    //博主姓名
    public function adminName()
    {
        $name = DB::name('admin')->where('id',1)->field('nickName,id')->find();
        $this->assign('name',$name);
    }
    //清除session
    public function logout()
    {
        session('user_name',NULL);
        return json(['status'=>1,'msg'=>'已安全退出你的登陆状态！']);
    }
    // 翻页
    public function PervAndNext($cid,$id,$api = false)
    {
        $DB = $this->db;
        // 上一篇
        $prev = $DB->where('id','<',$id)->where('cid',$cid)->order('id DESC')->limit(1)->value('id');
        $prev_title = $DB->where('id','<',$id)->where('cid',$cid)->order('id DESC')->limit(1)->value('title');
        $prev_create_time = $DB->where('id','<',$id)->where('cid',$cid)->order('id DESC')->limit(1)->value('create_time');
        // 下一篇
        $next = $DB->where('id','>',$id)->where('cid',$cid)->order('id ASC')->limit(1)->value('id');
        $next_title = $DB->where('id','>',$id)->where('cid',$cid)->order('id ASC')->limit(1)->value('title');
        $next_create_time = $DB->where('id','>',$id)->where('cid',$cid)->order('id ASC')->limit(1)->value('create_time');
        if($api) {
            $value = [
                'prev_id' => $prev,
                'prev_title' => $prev_title,
                'prev_create_time' => date("Y-m-d H:i:s",$prev_create_time),
                'next_id' => $next,
                'next_title' => $next_title,
                'next_create_time' => date("Y-m-d H:i:s",$next_create_time),
            ];
            return json_encode($value);
        }
        $this->assign(array(
            'prev' => $prev,
            'next' => $next,
            'prev_title' => $prev_title,
            'next_title' => $next_title
        ));
    }

    public function uploadImg()
    {
        if(request()->isAjax()){
            $res['code'] = 0;
            $res['msg'] = '上传成功!';
            $session = Session::has('user_name');
            if(!$session){
                return json(['msg'=>'请填写留言信息后再来上传图片吧！','status'=>0]);
            }
            $file = request()->file('file');
            $info = $file->validate(['size'=>4145728,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $src =  './uploads' . '/' . date('Ymd') . '/' . $info->getFilename();
                $image = Image::open($info);
                $image->thumb(250,250)->save($src);
                $image->save($src);
                $str=substr($src,1);
                $res['data']['title'] = $info->getFilename();
                $res['data']['src'] = $str;
            }else{
                $res['code'] = 1;
                $res['msg'] = '上传失败'.$file->getError();
            }
            return $res;

        }
    }
}
