<?php
namespace app\admin\controller;
use app\admin\server\GetChildrenId;
use app\admin\server\UnlimitTree;
use League\HTMLToMarkdown\HtmlConverter;
use Parsedown;
use think\Db;
use app\admin\model\Cate as CateModel;
class Cate extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('cate');
    }

    protected $beforeActionList = [
        'delsoncate' => ['only' => 'delete'],
    ];

    public function index()
    {
        $model = new CateModel();
        if($this->request->isPost()){
            $data = input('post.');
            foreach ($data as $k => $v) {
                $model->update(['id'=>$k,'sort'=>$v]);
            }
            return json(['msg'=>'更新成功！','status'=>1]);
        }
        $res = (new UnlimitTree())->catetree('cate');
        $this->assign([
            'res' => $res,
        ]);
        return view('',['title'=>'栏目']);
    }
    public function add()
    {
        //顶级栏目
        $pid = (new UnlimitTree())->catetree('cate');
        $this->assign('pid',$pid);
        return view('');
    }
    public function addPost()
    {
        if($this->request->isPost()){

            $Parsedown = new Parsedown();

            $data = $this->request->param();
            $validate = validate('Cate');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
//                $data['content']=urlencode($data['content']);//编码格式
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

        $pid = (new UnlimitTree())->catetree('cate');
        $this->assign(array(
            'res'=>$res,
            'pid'=>$pid
        ));
        return view();
    }

    public function editPost()
    {
        if($this->request->isPost()){

            $Parsedown = new Parsedown();

            $data = $this->request->param();
            $validate = validate('Cate');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
//                $data['content']=urlencode($data['content']);//编码格式
                $data['content'] = $Parsedown->text($data['content']);
                $data['edit_time']=time();
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
        //判断栏目下是否有文章
        $art = DB::name('article')->where(['cid'=>$id])->find();
        if($art){
            return json(['msg'=>'删除失败！请检查该栏目下是否有文章！','status'=>0]);
        }
        //判断栏目下是否有时间轴
        $timeline = DB::name('timeline')->where(['cid'=>$id])->limit(1)->find();
        if($timeline){
            return json(['msg'=>'删除失败！请检查该栏目下是否有时间轴！','status'=>0]);
        }
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
            //检查栏目下是否有文章
            $art = $this->is_article($ids);
            if($art){
                $this->error('删除失败！请检查该栏目下是否有文章！');
            }else{
                CateModel::destroy($ids);
                $this->success('删除成功！');
            }
        }
    }

    public function delsoncate()
    {
        $id = input('id');
        //检查栏目下是否有子栏目
        $sonids = (new GetChildrenId())->getchildrenid('cate',$id);
        foreach($sonids as $k=>$v){
            if(isset($v)){
                 $this->error('删除失败！请检查该栏目下是否有子栏目！');
            }
            //检查栏目下是否有文章
            $art = $this->is_article($v);
            if($art){
                $this->error('删除失败！请检查该栏目下是否有文章！');
            }else{
                if($sonids){
                    $this->db->delete($sonids);
                }
            }
        }
    }


    private function is_article($id)
    {
        $join=[
            ['__CATE__ c','c.id=a.cid','LEFT']
        ];
        return DB::name('article')->alias('a')->join($join)->whereIn('cid',$id)->select();
    }
}
