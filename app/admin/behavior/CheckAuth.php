<?php
/**
 * User: lh
 * Date: 2019/5/3
 * Time: 23:04
 */


namespace app\admin\behavior;

use think\exception\HttpResponseException;
use think\Session;
use think\Url;

class CheckAuth
{
    public function run() {
        //检查是否登录
        if (!Session::has('id') || !Session::has('username')) {

            $url = Url::build('admin/login/login');
            $response = redirect($url);
            throw new HttpResponseException($response);

        }

    }
}