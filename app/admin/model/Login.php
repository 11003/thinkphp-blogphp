<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/10/5
 * Time: 22:59
 */

namespace app\admin\model;

use think\Db;
use think\Model;
use think\Request;

class Login extends Model
{
    public function login($data)
    {
        $table = db('admin');

        if(!captcha_check($data['vercode'])){
            return 0;
        }

        $name = trim($data['username']);
        $result = $table->where(['username' => $name])->find();
        if(!empty($result)){
            if($result['status'] == 0){
                if((time() - $result['last_time']) > 300){
                    //过了锁定时间 恢复正常状态
                    $count['status'] = 1;
                    $table->where(['username' => $name])->update($count);
                }else{
                    //5分钟之后登录
                    return 3;
                }
            }
            if($result['password']== md5($data['password'] . config('salt'))){
                $ip = Request::instance()->ip();
                $time = time();
                if($data['username'] == 'test'){
                    $this->getUserIp($ip);
                }
                $table->where(['username' => $name])->update(['ip' => $ip, 'last_time' => $time, 'status' => 1]);

                session('id',$result['id']);
                session('username',$result['username']);
                session('last_time', time() + 1800);
                //登录成功
                return 4;
            }else{
                if($result['count'] <= config('login_error_num')){
                    // 错误小于三次 字段值增加
                    $count['count'] = $result['count']+1;
                    $table->where(['username' => $name])->update($count);
                } else {
                    // 错误次数大于3时 属性恢复 清空 锁定
                    $count['count'] = 0;
                    $count['last_time'] = time();
                    $count['status']  = 0;
                    $table->where(['username' => $name])->update($count);
                }
                //密码错误
                return 2;
            }
        }else{
            //用户不存在
            return 1;
        }
    }
    private function getUserIp($ip)
    {
        $test_user = DB::table('count_test_user')->whereTime('login_time','d')->where('ip',$ip)->find();
        if(!$test_user){
            DB::table('count_test_user')->insert(['ip'=>$ip, 'login_time' => time(),'uid' => session('id')]);
        }
    }
}
