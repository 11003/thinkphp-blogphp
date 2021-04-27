<?php
/**
 * User: Lh
 * Date: 2019/4/23
 * Time: 9:52
 */

namespace app\admin\controller;

use app\admin\server\UnlimitTree;
use think\Db;

class AuthGroup extends Base
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = DB::name('auth_group');
    }

    public function index()
    {
        $list = $this->db->paginate(10);
        return view('',['title'=>'角色管理','res'=>$list]);
    }

    public function add()
    {
        $pid = (new UnlimitTree())->catetree('auth_rule',TRUE);
        return view('',['pid'=>$pid]);
    }

    public function addPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
            if(isset($data['rules'])){
                $data['rules'] = implode(',',$data['rules']);
            }else{
                return json([ 'status' => 0, 'msg' => '角色组不能为空！']);
            }
            $validate = validate('AuthGroup');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $this->db->insert($data);
            return json([ 'status' => 1, 'msg' => '添加角色组成功！']);
        }

    }

    public function edit()
    {
        $id = input('id');
        $res = $this->db->where(['id'=>$id])->find();
        $pid = (new UnlimitTree())->catetree('auth_rule',TRUE);
        return view('',['res' => $res,'pid'=>$pid]);
    }

    public function editPost()
    {
        if($this->request->isPost()){
            $data = $this->request->param();
            if(isset($data['rules'])){
                $data['rules'] = implode(',',$data['rules']);
            }else{
                return json([ 'status' => 0, 'msg' => '角色组不能为空！']);
            }
            $validate = validate('AuthGroup');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }else{

                $res = $this->db->update($data);
                if($res){
                    return json(['msg'=>'修改角色组成功！','status'=>1]);
                }else{
                    return json(['msg'=>'修改角色组失败！','status'=>0]);
                }
            }
        }
    }

    public function delete()
    {
        $id = input('id');
        //判断角色组下是否有成员
        $auth_role = DB::name('auth_group_access')->where(['group_id'=>$id])->find();
        if(isset($auth_role)){
            return json(['msg'=>'删除失败！请检查该角色组下是否有成员！','status'=>0]);
        }else{
            $res = $this->db->where(['id'=>$id])->delete();
        }
        if($res){
            return json(['msg'=>'删除角色组成功！','status'=>1]);
        }else{
            return json(['msg'=>'删除角色组失败！','status'=>0]);
        }
    }

}
