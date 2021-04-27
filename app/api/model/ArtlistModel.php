<?php


namespace app\api\model;


use think\Db;
use think\Model;

class ArtlistModel extends Model
{
    protected $table = 'be_article';

    public function getListByWhere($page, $data, $cid)
    {
        $limit = $data['limitNumber'];
        $page_later = ($page - 1) * $limit;
        $order = "a.create_time desc";
        $join = [
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        $field="a.id,a.title,a.content,a.is_md,a.desc,a.pic,a.click,a.look,a.create_time,a.cid,a.rec,c.catename,c.pid";
        $db = DB::name("article")->alias('a')->field($field)->join($join);
        if(!$cid) {
            if(!empty($data['searchValue']) && isset($data['searchValue'])){
                $db->limit($page_later, $limit)->order('a.create_time desc')->where('a.desc|a.title|a.keywords|a.content','LIKE','%'.$data['searchValue'].'%');
            } else {
                $db->limit($page_later, $limit)->order($order);
            }
            $result = $db->select();
        } else {
            $result = DB::name("article")->alias('a')->field($field)->join($join)->limit($page_later, $limit)->order($order)->where('pid',$cid)->select();
            if(count($result) == 0){
                $result = DB::name("article")->alias('a')->field($field)->limit($page_later, $limit)->join($join)->order($order)->where('cid',$cid)->select();
            }
        }

        return $this->output($result);
    }
    // 统计搜索总数
    public function getSearchCount($page, $data) {
        $limit = $data['limitNumber'] || '';
        $page_later = ($page - 1) * $limit;
        $order = "a.update_time desc,a.create_time desc";
        $join = [
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        $field="a.id,a.title,a.content,a.is_md,a.desc,a.pic,a.click,a.look,a.create_time,a.cid,a.rec,c.catename,c.pid";
        $db = DB::name("article")->alias('a')->field($field)->join($join);
        return $db->limit($page_later, $limit)->order('a.create_time desc')->where('a.desc|a.title|a.keywords|a.content','LIKE','%'.$data['searchValue'].'%')->count();
    }
    //评论列表
    private function comment_list()
    {
        return DB::name("comment")->select();
    }
    private function output($data)
    {
        $arr = [];
        $comment_list = $this->comment_list();
        foreach ($data as $k => $v) {
            $v['create_time'] = transfer_time($v['create_time']);
            $v['content'] = $v['is_md'] == "" ? $this->cutstr_html(urldecode($v['content']), 100) : "🔒 这是一篇私密文章，有些内容可能不想给你看...";
            $v['rec'] = $v['rec'] ? "1" : "";
            $v['url'] = 'post.html?id=' . $v['id'];
            $v['look'] = LookNumbers($v['look']);
            //评论总数
            $v['comment_count_length'] = [];
            $v['comment_count'] = 0;
            foreach ($comment_list as $vv){
                if ($v['id'] == $vv['aid']) {
                    array_push($v['comment_count_length'], $vv['id']);
                    $v['comment_count'] = count($v['comment_count_length']);
                }
            }
            $arr[] = $v;
        }
        return $arr;
    }

    public function getCount($where = '')
    {
        return $this->where($where)->count('id');
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
}
