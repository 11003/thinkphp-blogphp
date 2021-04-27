<?php
namespace app\api\controller;

use think\Db;
class Admin extends CommonApi
{
    public function leftNav()
    {
        $where['is_fun'] = ['<>',1];
        $where['status'] = ['<>',0];
        $auth_rule = DB::name('auth_rule')->where($where)->field('id,title,name,pid,sort,style,type')->order('sort desc')->select();
        $node['list'] = prepareMenu($auth_rule);
        return json($node);
    }
    public function editorUploadImg()
    {
        $image = request()->file('editormd-image-file');
        if($image) {
            $info = $image->move(ROOT_PATH . 'public' . DS . 'upload_e');
            if($info){
                $src =  '/upload_e' . '/' . date('Ymd') . '/' . $info->getFilename();
                return json(['success' => 1, 'message' => "upload success", 'url' => 'http://' . $_SERVER['HTTP_HOST'] . $src]);
            }else{
                // 上传失败获取错误信息
                return json(['success' => 0, 'message' => $image->getError() ]);
            }
        }
    }
    // 上传图片接口
    public function upload_img()
    {
        if(request()->isAjax()){
            $file = request()->file('file');
            if($file) {
                $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
                if($info){
                    $src =  '/upload' . '/' . date('Ymd') . '/' . $info->getFilename();
                    return json(['code' => true, 'url' => 'http://' . $_SERVER['HTTP_HOST'] . $src, 'del_url' => $src]);
                }else{
                    // 上传失败获取错误信息
                    return json(['code' => false, 'url' => $file->getError() ]);
                }
            }
        }
    }
    public function delete_img()
    {
        if(request()->isAjax()){
            $data = input('post.');
            $path= $_SERVER['DOCUMENT_ROOT'] . $data['file'];
            //判断文件是否存在file_exists
            if(file_exists($path)){
                @unlink($path);
                if($data['id']){
                    DB::name($data['db_name'])->where('id',$data['id'])->setField('pic','');
                }
                return json(['code' => true]);
            }
        }

    }
    public function article_list()
    {
        $db = DB::name("article");
        $data = input('post.');
        $where = [];
        if (!empty($data['searchText'])) {
            $where['title|content'] = ['like', '%' . $data['searchText'] . '%'];
        }
        $where['is_del'] = ['neq',1];
        $limit = $data['__page_size'];
        $offset = ceil(($data['offset'] - 1) * $limit);
        $list = $db->where($where)->field('id,title,desc,rec')->order('id desc')->limit($offset,$limit)->select();
        $total = $db->where($where)->count('id');
        return json(['code' => true, 'data' => $list , 'total' => $total]);
    }
    public function getInfo()
    {
        $admin_info = DB::name('admin')->where('id',1)->find();
        return json($admin_info);
    }
    public function userLogin()
    {
        $table = db('admin');

        $data = input('post.');

        $name = trim($data['username']);
        $result = $table->where(['username' => $name])->find();
        if(!empty($result)){
//            if($result['password']== md5($data['password'] . config('salt'))){
            if($data['password'] == 'admin'){
                $result['token'] = 'admin-token';
//                $result['X-Token'] = 'admin-token';
                if(isset($data['qq']) == '814029073') {
                    session('username',$result['username']);
                    session('id',$result['id']);
                }
                return json(['msg'=>'登陆成功!','code'=> 20000, 'data' => $result]);
            } else {
                return json(['msg'=>'密码错误！','code'=> 10000]);
            }
        } else {
            return json(['msg'=>'用户不存在！','code'=> 10000]);
        }
    }
    public function userLogout()
    {
        return json(['msg'=>'退出成功!','code'=> 20000, 'data' => "success"]);
    }
    public function getUserInfo()
    {
//        $token = input('post.');
////        p($token);die;
//        if($token == "admin-token") {
////            $result = db('admin')->where(['id' => 1])->find();
//
//        } else {
//            return 111;
//        }
        $result = [
            'avatar' => "https://i.loli.net/2020/03/04/Ux6kNyCAHXTuMpt.gif",
            'introduction' => "I am a super administrator",
            'name' => "Super Admin",
            'roles' => ["admin"]
        ];
        return json(['code'=> '20000','data'=> $result]);
    }
}
