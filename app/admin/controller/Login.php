<?php
/**
 * User: admin
 * Date: 2018/10/5
 * Time: 22:52
 */

namespace app\admin\controller;

use app\admin\model\LoginLog;
use think\captcha\Captcha;
use think\Controller;
use app\admin\model\Login as LoginModel;
use think\Db;

class Login extends Controller
{
    public function login()
    {
        return view('', ['title' => '后台登录']);
    }

    public function loginPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            if(!$data['username']) {
                return json(['msg' => '请填写用户名!', 'status' => 4]);
            }
            if(!$data['password']) {
                return json(['msg' => '请填写密码!', 'status' => 5]);
            }
            if(!$data['vercode']) {
                return json(['msg' => '请填写验证码!', 'status' => 6]);
            }
            $log = new LoginLog();
            $login = new LoginModel();
            $res = $login->login($data);
            switch ($res) {
                case 0 :
                    $log->writeLoginLog($data['username'] . "（验证码错误）", 2);
                    return json(['msg' => '验证码错误!', 'status' => 0]);
                    break;
                case 1 :
                    $log->writeLoginLog($data['username'] . "（用户不存在）", 2);
                    return json(['msg' => '用户不存在!', 'status' => 1]);
                    break;
                case 2:
                    $log->writeLoginLog($data['username'] . "（密码错误）", 2);
                    return json(['msg' => '密码错误!', 'status' => 2]);
                    break;
                case 3:
                    $log->writeLoginLog($data['username'] . "（账号或密码错误超过".config('login_error_num')."次）", 2);
                    return json(['msg' => '账号或密码错误超过'. config('login_error_num') .'次,请5分钟之后登录!', 'status' => 3]);
                    break;
                default:
                    $log->writeLoginLog($data['username'], 1);
                    return json(['msg' => '登陆成功!', 'status' => 20000, 'url' => url('index/index')]);

            }
        }
    }

    public function logout()
    {
        if (session('username')) {
            $log = new LoginLog();
            $log->writeLoginLog(session('username') . "（退出系统）", 1);
        }
        session('username', null);
        session('id', null);
        return view('login');
    }

    public function forgotPass()
    {
        if ($this->request->isPost()) {
            $log = new LoginLog();
            $data = $this->request->param();
            if($data['qq_email'] == config('smtp_setting.address')) {
                $res = DB::name('admin')->where(['username' => $data['name']])->find();
                if($res) {
                    $code = mt_rand(100000,999999);
                    $update_md5_pass = md5($code . config('salt'));
                    $update_data = DB::name('admin')->where('id',$res['id'])->update(['password'=>$update_md5_pass,'forgotPass'=>1]);
                    if($update_data) {
                        send_email_by_forgotPass($code);
                        $log->writeLoginLog($res['username'] . "（忘记密码，邮箱发送成功）", 1);
                        return json(['msg' => '验证成功!', 'status' => 200]);
                    } else {
                        $log->writeLoginLog($res['username'] . "（忘记密码，邮箱发送失败）", 0);
                        return json(['msg' => '验证失败!请尝试使用初始密码或联系管理员。', 'status' => 200]);
                    }
                } else {
                    return json(['msg' => '未找到该用户!', 'status' => 0]);
                }
            }
            return json(['msg' => '验证失败!', 'status' => 0]);
        }
    }
}
