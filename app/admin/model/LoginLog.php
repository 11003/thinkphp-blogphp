<?php

namespace app\admin\model;

use think\Log;
use think\Model;
use think\Request;

class LoginLog extends Model
{
    protected $table = 'be_login_log';

    /**
     * 写登录日志
     * @param $user
     * @param $status
     */
    public function writeLoginLog($user, $status)
    {
        try {

            $this->insert([
                'login_user' => $user,
                'login_ip' => request()->ip(),
                'login_area' => getLocationByIp(request()->ip()),
                'login_user_agent' => Request::instance()->header('user-agent'),
                'login_time' => date('Y-m-d H:i:s'),
                'login_status' => $status
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * 登录日志明细
     * @param $limit
     * @return array
     */
    public function loginLogList($key)
    {
        try {
            $map = [];
            if($key) {
                $map['login_status']=['eq',$key];
            }
            $list = $this->order('log_id', 'desc')->where($map)->paginate(10);
            foreach($list as $k=>$v){
                $list[$k]['unlimit_login_user_agent'] = $v['login_user_agent'];
                $list[$k]['login_user_agent'] = subtext($v['login_user_agent'],80);
                $list[$k]['login_status'] = $v['login_status'] == 1 ? "<span class='label label-success'>成功</span>" : "<span class='label label-darkpink'>失败</span>";
            }
            return $list;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
