<?php

namespace tool;

use app\admin\model\OperateLog;

class Log
{
    public static function write($content)
    {
        $controller = lcfirst(request()->controller());
        $action = request()->action();
        $checkInput = $controller . '/' . $action;
        $logModel = new OperateLog();
        $logModel->writeLog([
            'operator' => session('username'),
            'operator_ip' => request()->ip(),
            'operate_method' => $checkInput,
            'operate_desc' => $content,
            'operate_time' => date('Y-m-d H:i:s')
        ]);
    }
}