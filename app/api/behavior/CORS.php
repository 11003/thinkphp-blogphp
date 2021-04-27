<?php

namespace app\api\behavior;

class CORS
{
    public function appInit(&$params)
    {
        $white_list = ['https://blog.liuhai.fun', 'http://element.liuhai.fun', 'http://antv.liuhai.fun'];

        if (!empty($_SERVER['HTTP_ORIGIN'])) {
            $http_origin = $_SERVER['HTTP_ORIGIN'];

            //设置 header 信息
            header("Access-Control-Allow-Origin: {$http_origin}");
            header("Access-Control-Allow-Methods", "POST,GET");
            header('Access-Control-Allow-Credentials:true');  //允许访问Cookie
            header('Access-Control-Allow-Headers : x-token,token, Origin, X-Requested-With, Content-Type, Accept'); //设置Headers
            if (request()->isOptions()) {
                exit();
            }
        }
    }
}
