<?php
/**
 * User: Lh
 * Date: 2019/9/7 0:02
 */

namespace app\api\controller;

use app\index\controller\Article;
use app\index\controller\Common;
use Parsedown;
use think\Db;
use think\Validate;

class Index extends CommonApi
{
    const AboutMe = 41; // 关于我
    const Friend = 62; // 友情链接
    const Timeline = 60; // 时间轴

    const _defaultAvatar = 'https://gitee.com/liuhaier/images/raw/master/img/20210412171452.png';
    //首页列表
    public function index()
    {
        $data = input('get.');
        $index_page = new Artlist();
        $art_res = $index_page->page_list($data);
        return $art_res;
    }
    //条件列表
    public function artlist()
    {
        $data = input('get.');
        $index_page = new Artlist();
        $art_res = $index_page->page_list($data);
        return $art_res;
    }
    //php根据时间顺序显示文章
    public function timelist() {
        $articles = db("article")->order('create_time desc')->field('title,create_time,is_md,rec,id,cid')->select();
        $res = [];
        foreach ($articles as $article) {
            $year = date('Y年m月', $article['create_time']);
            $article['create_time'] = date('m月d日',$article['create_time']);
            $article['rec'] = $article['rec'] ? "1" : "";
            $article['url'] = 'post.html?id=' . $article['id'];
            $res[$year][] = $article; //以年为单位，作为数组索引，
        }
        return json($res);
    }
    // 首页大屏
    public function indexVideo()
    {
        $indexVideo = DB::name('new_index_video')->field('img_data,video_data')->where('status=1')->order('update_time desc,create_time desc')->limit(1)->select()[0];
//        $indexVideo['img_data'] = substr($indexVideo['img_data'],0,-4);
//        $indexVideo['video_data'] = substr($indexVideo['video_data'],0,-4);
        return json_encode($indexVideo);
    }
    private function cutstr_html($string, $sublen)
    {
        $string = strip_tags($string);
        $string = preg_replace('/\n/is', '', $string);
        $string = preg_replace('/ |　/is', '', $string);
        $string = preg_replace('/&nbsp;/is', '', $string);
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);
        if (count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen)) . "…";
        else $string = join('', array_slice($t_string[0], 0, $sublen));
        return $string;
    }
    //导航栏
    public function navigation()
    {
        $common = new Common();
        $nav = $common->getNavCates(true);
        return $nav;
    }

    //系统配置
    public function conf()
    {
        $common = new Common();
        $conf = $common->getConf(true);
        return $conf;
    }

    //友情链接
    public function link()
    {
        $common = new Common();
        $link = $common->Link(true);
        return $link;
    }

    //热点文章
    public function hot()
    {
        $common = new Common();
        $hot_article = $common->HotRes("", true, 3);
        return $hot_article;
    }

    // 通过cid获取当前栏目名称
    public function getCateNameByCid()
    {
        $cid = input('get.cid');
        $catename = DB::name("cate")->where(['id' => $cid])->field('catename,id')->find()['catename'];
        return json(['catename' => $catename]);
    }

    //相关文章
    public function like_article()
    {
        $get = input('get.');
        $article = new Article();
        $rec = $article->rec($get['cid'], $get['id'], $get['is_index'],true);
        return $rec;
    }

    // 通过密码获取文章
    public function checkArticlePass($pass) {
        $common = new Common();
        return $pass == $common->_conf_articlePass;
    }
    //文章详情
    public function post()
    {
        $id = input("id");
        $pass = input('pass');
        $article = new Article();
        $post_res = $article->find($id, "",true);
        $post_res = json_decode($post_res,true);
        if($pass){
            if($this->checkArticlePass($pass)){
                return json_encode($post_res);
            } else {
                return json(['code' => false, 'msg' => '密码错误']);
            }
        } else {
            DB::name('article')->where('id', $id)->setInc('look');
            if($post_res['is_md'] == 1) {
                $post_res['content'] =
                $post_res['keywords'] =
                $post_res['editor_html_code'] =
                $post_res['desc'] = "";
            }
            return json_encode($post_res);
        }



    }
    //翻页
    public function page()
    {
        $id = input('id');
        $is_index = input('is_index');
        $search = input('search');
        $cid = input('cid');
        $filed = "title,id,create_time";
        // 上一篇
        $prev_sql = DB::name('article')->field($filed);
        // 下一篇
        $next_sql = DB::name('article')->field($filed);
        if($is_index === 'undefined'||$is_index==='false') {
            $join = [['__CATE__ c','c.id=a.cid','LEFT']];
            $prev = DB::name('article')->alias('a')->where('a.id', '<', $id)->order('a.id DESC')->where('c.pid',$cid)->field('a.title,a.id,a.create_time')->join($join)->find();
            $next = DB::name('article')->alias('a')->where('a.id', '>', $id)->order('a.id ASC')->where('c.pid',$cid)->field('a.title,a.id,a.create_time')->join($join)->find();
            if(!$prev&&!$next) {
                $prev = $prev_sql->where('id', '<', $id)->where('cid', $cid)->order('id DESC')->find();
                $next = $next_sql->where('cid', $cid)->where('id', '>', $id)->order('id ASC')->find();
            }
        } elseif ($is_index === true) {
            $prev = $prev_sql->where('id', '<', $id)->order('id DESC')->find();
            $next = $next_sql->order('id ASC')->where('id', '>', $id)->find();
        } else {
            // 搜索
            $prev = $prev_sql->where('content|title|keywords|desc','LIKE','%'.$search.'%')->where('id', '<', $id)->order('id DESC')->find();
            $next = $next_sql->where('content|title|keywords|desc','LIKE','%'.$search.'%')->order('id ASC')->where('id', '>', $id)->find();
        }

        if ($next) {
            $next['create_time'] = "发表于" . date("Y-m-d H:i:s", $next['create_time']);
        }
        if ($prev) {
            $prev['create_time'] = "发表于" . date("Y-m-d H:i:s", $prev['create_time']);
        }
        $data = [
            'prev' => $prev,
            'next' => $next
        ];
        return json($data);
    }

    public function comment_new($id)
    {
        $article = new Article();
        $comments = $article->commentIndex("", $id, true);
        return $comments;
    }

    private function comment_and_reply($comment_list, $reply_list)
    {
        foreach ($comment_list as &$v) {
            $v['reply'] = [];
            $address = getAddressByIp($v['ip']);
            unset($v['ip']);
            $v['nameplate'] = $this->rule($v['rule'],$address);
            $v['user_avatar'] =$v['user_avatar']?:self::_defaultAvatar;
            foreach ($reply_list as $vv) {
                unset($vv['ip']);
                if ($v['id'] == $vv['mid']) {
                    $vv['date_create_time'] = date("Y-m-d H:i:s", $vv['create_time']);
                    $vv['create_time'] = transfer_time($vv['create_time']);
                    $vv['nameplate'] = $vv['uid'] == 1 ? '<a class="comment_ordinary comment_ordinary_user_admin">博主</a>' : "";
                    array_push($v['reply'], $vv);

                }
            }
        }
        unset($v);
        return $comment_list;
    }

    //评论列表
    public function comment()
    {
        $id = input("id");
        $replys = $this->reply();
        $comments = $this->comment_new($id);
        $res = $this->comment_and_reply($comments, $replys);

        $reply = [];
        foreach ($res as $k => $v) {
            $reply[] = count($v['reply']);
        }

        // array_sum 将数组的值相加
        $counts = (int)count($comments) + (int)array_sum($reply);

        return json(['comment' => $res, 'count' => $counts]);
    }

    //回复列表
    public function reply()
    {
        $article = new Article();
        $replys = $article->replyIndex();
        return $replys;
    }

    //关于我
    public function aboutMe($from_index = false)
    {
        $cid = input('cid',41);
        $about = DB::name("cate")->where('id', '=', $cid)->find();

        if(empty($about['content'])){
            $about['content'] = getDayArticle();
        }
        if($about['catename'] == '关于我') {
            $super_admin = DB::name("admin")->where(['id' => 1])->field('username,nickName,desc,pic')->find();

            $about['super_admin_info'] = $super_admin;
        }
        if ($from_index) {
            $about['content'] = subtext($about['content'], 600);
        }
        return json($about);
    }
    public function timeline()
    {
        $timeline = DB::name('timeline')->where('status',1)->order('create_time desc')->select();

        foreach ($timeline as $k => $v) {
            $timeline[$k]['content'] = img_lazy($v['content']);
            $timeline[$k]['create_time'] = transfer_time($v['create_time']);
        }
        return json($timeline);
    }

    public function addComment()
    {
        $Parsedown = new Parsedown();
        $validate = new Validate([
            'name' => 'require|min:2|max:15',
            'email' => 'require|email',
            'content' => 'require|min:2|max:2000',
        ]);
        $validate->message([
            'name.require' => '别忘了你的名字喔！',
            'name.min' => '用户名最少两个字符',
            'name.max' => '用户名最大十五个字符',
            'email.require' => '邮箱还没填呢！',
            'email' => '邮箱格式错误！',
            'content.require' => '总要写点什么吧？',
            'content.min' => '内容最少2个字符！',
            'content.max' => '内容最大2000个字符！',
        ]);
        $get = input('post.');
        if (!$validate->check($get)) {
            return json(['msg' => $validate->getError(), 'status' => 0]);
        } else {
            $data['create_time'] = time();
            $data['ip'] = get_client_ip();
            $content = string_remove_xss($get['content']);
            $data['user_comment'] = $Parsedown->text($content);
            $data['user_name'] = string_remove_xss(trim($get['name']));
            $data['user_email'] = string_remove_xss(trim($get['email']));
            $data['user_avatar'] = letter_avatar(trim($get['name']));
            if(isset($get['aid'])) {
                $data['aid'] = string_remove_xss($get['aid']);
            }
            if(isset($get['cid'])) {
                $data['cid'] = string_remove_xss($get['cid']);
            }
            $res = DB::name('comment')->insertGetId($data);
            if ($res) {
                session('user_name', $get['name']);
                session('user_email', $get['email']);
                $reply_name = session('user_name');
                $reply_email = session('user_email');
                if(isset($get['aid'])) {
                    //文章
                    $title = "<a href='". config('my_web.blog_address') ."/post/{$data['aid']}?cid${$data['cid']}&index=true'>"."【".getAddressByIp($data['ip'])."】".$data['user_name']."</a>";
                } else {
                    //关于我
                    $title = "<a href='".config('my_web.blog_address')."/page/关于我?cid=41'>"."【".getAddressByIp($data['ip'])."】".$data['user_name']."</a>";
                }
                // 发送Server酱
//                sc_send($title,$data['user_comment']);
                return json(['msg' => '评论成功！', 'status' => 200, 'comment_id' => $res, 'reply_data' => ['reply_name_by_session' => $reply_name,'reply_email_by_session' => $reply_email]]);
            } else {
                return json(['msg' => '评论失败！', 'status' => 0]);
            }
        }
    }

    public function addReply()
    {
        $Parsedown = new Parsedown();

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
            if(!empty($data['reply_email_by_session']) && !empty($data['reply_email_by_session'])) {
                $session = [
                    'reply_name_by_session' => $data['reply_name_by_session']?:"",
                    'reply_email_by_session' => $data['reply_email_by_session']?:"",
                ];
            } else {
                return json(['msg'=>'请填写留言信息后再来回复『'.$data['uName'].'』吧！','status'=>0]);
            }
            $reply_name = $session['reply_name_by_session'];
            $content = string_remove_xss($data['content']);//编码格式
        }
        if (!$validate->check($data)) {
            return json(['msg' => $validate->getError(), 'status' => 0]);
        }else{
            $data['reply_name']= $reply_name;
            $data['content'] = $Parsedown->text($content);
            unset($data['reply_email_by_session']);
            unset($data['reply_name_by_session']);
            $res = DB::name('reply')->insert($data);
            if($res){
                return json(['msg'=>'回复成功！','status'=>1]);
            }else{
                return json(['msg'=>'回复失败！','status'=>0]);
            }
        }
    }
}
