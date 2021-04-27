<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Conf as ConfModel;
class Conf extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('conf');
    }

	//配置项
	public function index()
	{
		$model = new ConfModel();
		if($this->request->isPost()){
            $data = input('post.');
            foreach ($data as $k => $v) {
                $this->db->update(['id'=>$k,'sort'=>$v]);
            }
            return json(['msg'=>'更新成功！','status'=>1]);
        }
		$res = $model->order('sort desc')->select();
		$this->assign("res",$res);
		return view('',['title'=>'系统&nbsp;&nbsp;/&nbsp;&nbsp;配置项']);
	}
	//配置列表
	public function lists()
	{
		$model = new ConfModel();
		$res = $model->order('sort desc')->select();
		$this->assign('res',$res);
		return view('',['title'=>'系统&nbsp;&nbsp;/&nbsp;&nbsp;配置列表']);
	}
	public function listsPost()
    {
        if($this->request->isPost()){
            $model = new ConfModel();
            $data = $this->request->param();
            //复选框逻辑 对比
            $formarr = array();
            foreach ($data as $k => $v) {
                $formarr[]=$k;
            }
            $conf_arr = db('conf')->field('en_name')->select();
            $confarr = array();
            foreach ($conf_arr as $k => $v) {
                $confarr[]=$v['en_name'];
            }
            // dump($confarr);die;
            $checkbox_arr=array();
            foreach ($confarr as $k => $v) {
                if(!in_array($v,$formarr)){
                    $checkbox_arr[]=$v;
                }
            }
            if($checkbox_arr){
                foreach ($checkbox_arr as $k => $v) {
                    ConfModel::where('en_name',$v)->update(['value'=>'']);
                }
            }
            if($data){
                foreach ($data as $k => $v) {
                    $model->where('en_name',$k)->update(['value'=>$v]);
                }
                return json(['msg'=>'修改配置成功！','status'=>1]);
            }
        }
    }

	public function edit()
	{
		$id = input('id');
		$res = $this->db->where(['id'=>$id])->find();
		$this->assign('res',$res);
		return view();
	}
	public function editPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
             $validate = validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
	            $data['update_time']=time();
	            $data['values']=str_replace("，", ",", $data['values']);
	            $res = $this->db->update($data);
	            if($res){
	                return json(['msg'=>'修改成功！','status'=>1]);
	            }else{
	                return json(['msg'=>'修改失败！','status'=>0]);
	            }
            }
        }
    }

	public function add()
	{
		return view();
	}
	public function addPost()
	{
		if($this->request->isPost())
		{
			$data = $this->request->param();
			 //验证
            $validate = validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $data['create_time']=time();
                $data['values']=str_replace("，", ",", $data['values']);
                $res = $this->db->insert($data);
                if($res){
                    return json(['msg'=>'添加成功！','status'=>1]);
                }else{
                    return json(['msg'=>'添加失败！','status'=>0]);
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


    /**
     * 图标库
     */
	public function awesome()
    {
        return view('',['title' => 'FontAwesome Icons']);
    }

    public function newIndexVideo()
    {
        $res = DB::name('new_index_video')->order('create_time desc')->select();
        foreach ($res as $k => $v) {
            $res[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $res[$k]['video_data'] = '<video height="150" controls><source src="'. $v['video_data'] .'" type="video/mp4"><source src="'. $v['video_data'] .'" type="video/webm">您的浏览器不支持 video 标签。</video>';
            $res[$k]['img_data'] = $v['img_data'] ? '<img style="cursor: pointer" src="'. $v['img_data'] .'" name="src" height="150">' : "";
        }
        $this->assign('res',$res);
        return view('',['title' => '新首页视频图片资源']);
    }
    public function add_video()
    {
        if(request()->isPost()){
            $data = input('post.');
            if(!$data['video_data']) {
                return json(['msg'=>'视频不能为空！','status'=>0]);
            }
            if(!$data['img_data']) {
                return json(['msg'=>'图片不能为空！','status'=>0]);
            }
            $data['create_time'] = time();
            $res = DB::name('new_index_video')->insert($data);
            if($res) {
                return json(['msg'=>'添加成功！','status'=>1]);
            }else{
                return json(['msg'=>'添加失败！','status'=>0]);
            }
        }
        return view();
    }
    public function edit_video()
    {
        $id = input('id');

        if(request()->isPost()){
            $data = input('post.');

            if(!$data['video_data']) {
                return json(['msg'=>'视频不能为空！','status'=>0]);
            }
            if(!$data['img_data']) {
                return json(['msg'=>'图片不能为空！','status'=>0]);
            }
            $res = DB::name('new_index_video')->where('id',$data['id'])->update($data);
            if($res) {
                return json(['msg'=>'修改成功！','status'=>1]);
            }else{
                return json(['msg'=>'修改失败！','status'=>0]);
            }
        }

        $res = self::getNewIndexVideoById($id);;
        $this->assign('res',$res);
        return view();
    }

    public function delete_video()
    {
        $id = input('id');
        self::beforeDeleteData($id,'video_data');
        self::beforeDeleteData($id,'img_data');
        $res = DB::name('new_index_video')->where('id',$id)->delete();
        if($res) {
            return json(['msg'=>'删除成功！','status'=>1]);
        } else {
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }

    public function status()
    {
        $id = input('id');
        $status = input('status');
        $data = [
            'status' => $status,
            'update_time' => time()
        ];
        $res = DB::name('new_index_video')->where('id',$id)->update($data);

        $msg = [
            1 => '显示',
            0 => '关闭'
        ];

        if($res) {
            return json(['msg'=> '该主屏已'.$msg[$status],'status'=> 1]);
        } else {
            return json(['msg'=> '修改失败！','status'=> 0]);
        }
    }

    // 上传视频
    public function upload_video()
    {
        if(request()->isAjax()){
            $file = request()->file('fileVideo');
            $id = input('id');
            if($id) {
                self::beforeDeleteData($id,'video_data');
            }
            if($file) {
                $info = $file->move(ROOT_PATH . 'public' . DS . 'upload_video');
                if( $info->getExtension() == 'mp4' ) {
                    if($info){
                        $src =  '/upload_video' . '/' . date('Ymd') . '/' . $info->getFilename();
                        $url = 'https://' . $_SERVER['HTTP_HOST'] . $src;
                        return json(['code' => true, 'url' => $url]);
                    }
                }
                return json(['code' => false, 'url' => '上传格式错误，请上传MP4格式的视频' ]);
            }
        }
    }
    // 上传图片
    public function upload_img()
    {
        if(request()->isAjax()){
            $file = request()->file('fileImg');
            $id = input('id');
            if($id) {
               self::beforeDeleteData($id,'img_data');
            }
            if($file) {
                $info = $file->move(ROOT_PATH . 'public' . DS . 'upload_video');
                if( $info->getExtension() != 'mp4' ) {
                    if($info){
                        $src =  '/upload_video' . '/' . date('Ymd') . '/' . $info->getFilename();

                        $url = 'https://' . $_SERVER['HTTP_HOST'] . $src;
                        return json(['code' => true, 'url' => $url]);
                    }
                }
                return json(['code' => false, 'url' => '上传格式错误，请上传图片' ]);
            }
        }
    }
    private static function beforeDeleteData($id,$dataName)
    {
        $video_data = self::getNewIndexVideoById($id);
        $url = strstr($video_data[$dataName],'/upload_video');
        $path = $_SERVER['DOCUMENT_ROOT'] . $url;
        if(file_exists($path)){
            @unlink($path);
        }
    }
    private static function getNewIndexVideoById($id)
    {
        return DB::name('new_index_video')->find(['id'=>$id]);
    }
}
