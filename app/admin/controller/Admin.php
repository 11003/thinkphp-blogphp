<?php
namespace app\admin\controller;
use think\Db;
use tool\Log;

class Admin extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('admin');
    }

    public function index()
    {
        $res = $this->db->select();
        $auth = new Auth();

        //把权限加在里面
        foreach ($res as $k=>$v){
            if($v['id'] == 1){
                $res[$k]['auth_title']='*';
                $res[$k]['group_id'] = '';
            }else{

                $auth_groups_id = $auth->getGroups($v['id']);
                $res[$k]['auth_title'] = $auth_groups_id ? $auth->getGroups($v['id'])[0]['title'] : '无';
                $res[$k]['group_id'] = $auth_groups_id ? $auth->getGroups($v['id'])[0]['group_id']: 0;
            }
        }
        $this->assign('res',$res);
        return view('',['title'=>'管理员']);
    }
    public function add()
    {
        $auth_group=$this->getAuthGroup();
        return view('',['auth_group'=>$auth_group]);
    }
    public function addPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();

            $validate = validate('Admin');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{

                if(trim($data['password'])<=6){
                    return json(['msg'=>'密码长度必须大于六位！','status'=>0]);
                }
                unset($data['password_confirm']);

                $insert_data= [
                    'nickName' => $data['nickName']?:$data['username'],
                    'pic'  => $data['pic'] ? : letter_avatar($data['username']),
                    'username' => $data['username'],
                    'info' => $data['info'],
                    'del_url' => $data['del_url'],
                    'desc' => $data['desc'],
                    'create_time' => time(),
                    'password' => md5($data['password'] . config('salt'))
                ];
                $res = $this->db->insertGetId($insert_data);
                if($res){

                    Log::write(session('username') . "添加了管理员：" . $insert_data['username']);

                    $this->altAuthGroupAccessBb($res,$data['group_id']);
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
        $res = $this->db->find($id);
        if(!$res) {
            $this->error('未查询到该用户');
        }
        $auth_group=$this->getAuthGroup();
        $group_id = $this->getAuthGroupAccessByUid($res['id']);
        return view('',['res' => $res,'auth_group'=>$auth_group,'group_id'=>$group_id]);
    }
    public function editPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
            $admins= $this->db->find($data['id']);
            $validate = validate('Admin');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            } else {
                $update_data= [
                    'nickName' => $data['nickName']?:$data['username'],
                    'pic'  => $data['pic'],
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'info' => $data['info'],
                    'desc' => $data['desc'],
                    'forgotPass' => 0,
                    'update_time' => time(),
                    'password' => $data['password']?md5($data['password'] . config('salt')):$admins['password']
                ];

                $res = $this->db->update($update_data);
                if($res){

                    Log::write(session('username') . "修改了管理员（ID:". $data['id'] ."）：" . $update_data['username']);

                    if($data['id'] != 1){
                        $this->altAuthGroupAccessBb($data['id'],$data['group_id'],FALSE);
                    }
                    return json(['msg'=>'修改成功！','status'=>1]);
                }else{
                    return json(['msg'=>'修改失败！','status'=>0]);
                }
            }


        }
    }
    public function delete()
    {
        $id= input('id');
        if($id == 1){
            return json(['msg'=>'超级管理员不能删除！','status'=>0]);
        }
        $del_data = $this->db->find($id);

        $res = $this->db->where('id',$id)->delete();
        if($res){

            Log::write(session('username') . "删除了管理员：" . $del_data['username']);

            $this->delAuthGroupAccessBb($id);
            return json(['msg'=>'删除成功！','status'=>1]);
        }else{
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }


    private function getAuthGroup()
    {
        return DB::name('auth_group')->where('status',1)->select();
    }

    private function getAuthGroupAccessByUid($uid)
    {
        return DB::name('auth_group_access')->where('uid',$uid)->find()['group_id'];
    }
    private function altAuthGroupAccessBb($uid,$group_id,$is_add = TRUE)
    {
        $data = ['uid' => $uid, 'group_id' => $group_id];

        if($is_add){
            return DB::name('auth_group_access')->insert($data);
        } else {
            return DB::name('auth_group_access')->where('uid',$uid)->update($data);
        }
    }

    private function delAuthGroupAccessBb($uid)
    {
        return DB::name('auth_group_access')->where('uid',$uid)->delete();
    }
}
