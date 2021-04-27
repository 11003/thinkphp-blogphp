<?php
namespace app\admin\controller;

use app\index\controller\Common;
use think\Controller;
use think\Db;
use think\Hook;

class Base extends Controller
{
    private $_uid = "";

    public function _initialize()
    {
        $api = input('api');
        if ($api != config('api_rule')) {
            //注册行为
            Hook::add('app_init','app\\admin\\behavior\\CheckAuth');
            //监听行为
            Hook::listen('app_init');
            $this->checkAuth();
        }
        $this->leftNav();
        $this->resources();
    }

    private function getuid()
    {
        return $this->_uid = session('id');
    }

    /**
     * 检测权限
     */
    private function checkAuth()
    {
        $uid = $this->getuid();

        $BlogPHP = $this->getModelHttp();
        $auth = new Auth();
        if(in_array($BlogPHP,config('notCheck')) || $uid == 1){
            return true;
        }
        // 自己的信息
        if($uid == input('id') && in_array($BlogPHP,['admin/edit', 'admin/editpost']) ) {
            return true;
        }
        if(!$auth->check($BlogPHP,$uid)){
            $this->error('权限不足！',"index/index");
        }
    }

    /**
     * 获取当前控制器和当前方法
     */
    private function getModelHttp()
    {
        $controller = $this->toUnderScore(request()->controller());
        $action = strtolower(request()->action());
        return $controller . '/' . $action;
    }

    /**
     * 通过权限来显示左侧栏目
     */
    private function leftNav()
    {
        $auth_rule = $this->getUserAuthGroupInfoById();

        $model = $this->getModelHttp();
        $controller = request()->controller();
        $url = request()->url();

        $node = prepareMenu($auth_rule);

        cache('node',$node);
        return $this->assign([
            'node' => cache('node'),
            'model' => $model,
            'controller' => $controller,
            'url' => $url
        ]);
    }

    /**
     * 获取角色下所有对应的节点id
     */
    private function getUserAuthGroupInfoById()
    {
        $auth = new Auth();
        $where['is_menu'] = ['eq', 2]; // 菜单
        $where['status'] = ['eq', 1]; // 启用
        $field = "is_menu,id,title,name,pid,sort,style";

        if($this->getuid() == 1) {
            $auth_rule = DB::name('auth_rule')->where($where)->field($field)->order('sort desc')->select();
        } else {
            $auth_groups_id = $auth->getGroups(session('id'))[0];
            $auth_rule = DB::name('auth_rule')->where($where)->whereIn('id',$auth_groups_id['rules'])->field($field)->order('sort desc')->select();
        }
        return $auth_rule;
    }

    private function resources()
    {
        //登陆用户信息
        $userInfo = $this->adminInfo();
        $danger_info_by_pass = $this->editPass($userInfo);
        //评论
        $comment = DB::name('comment')->whereTime('create_time','w')->field('user_name,user_comment,ip,create_time')->order('create_time DESC')->select();

        foreach ($comment as $k=>$v){
            $comment[$k]['user_name'] = urldecode($v['user_name']);
            $comment[$k]['user_comment'] = isIncludedImg('[图片]',$v['user_comment']);
            $comment[$k]['address'] = getAddressByIp($v['ip']);
        }
        $comment_count = DB::name('comment')->whereTime('create_time','w')->field('id')->count('id');

        $test_login_count = DB::table('count_test_user')->field('id,login_time,ip')->order('id DESC')->paginate(5);
        $test_login_count_item = $test_login_count->items(); // 获取分页状态下的data数据
        foreach ($test_login_count_item as $i=>$e){
            $test_login_count_item[$i]['address'] = getAddressByIp($e['ip']);
            $test_login_count_item[$i]['login_time'] = date('Y-m-d H:i:s',$e['login_time']);
        }
        return $this->assign([
            'userInfo'=> $userInfo,
            'danger_info_by_pass'=> $danger_info_by_pass,
            'comment' => $comment,
            'comment_count' => $comment_count,
            'test_login_count' => $test_login_count_item,
            'count_page' => $test_login_count->render()
        ]);
    }

    private function editPass($userInfo)
    {
        $danger_info_by_pass = "";
        if($userInfo['forgotPass']) {
            $danger_info_by_pass = "<b style='color:red'>（您的密码危险系数高,请及时<a href='javascript:void(0);' title='修改{$userInfo['username']}的信息' updateurl='/admin/admin/edit/id/{$userInfo['id']}.html' class='update'>修改密码</a>）</b>";
        }
        return $danger_info_by_pass;
    }

    private static $_arr_auth_str =[];
    private function toUnderScore($str)
    {
        if(!isset(self::$_arr_auth_str[$str])){
            $auth_str = preg_replace_callback('/([A-Z]+)/',function($matchs)
            {
                return '_'.strtolower($matchs[0]);
            },$str);
            self::$_arr_auth_str[$str] = trim(preg_replace('/_{2,}/','_',$auth_str),'_');
        }

        return self::$_arr_auth_str[$str];
    }

    public function adminInfo()
    {
        return DB::name('admin')->where('id',$this->getuid())->find();
    }
}
