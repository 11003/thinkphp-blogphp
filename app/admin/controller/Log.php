<?php

namespace app\admin\controller;

use app\admin\model\LoginLog;
use app\admin\model\OperateLog;
use think\Db;

class Log extends Base
{
    // 登录日志
    public function login()
    {
        $status = input('status');

        $log = new LoginLog();
        $list = $log->loginLogList($status);

        $this->assign([
            'res' => $list
        ]);
        return view('',['title'=>'登录日志']);
    }

    // 操作日志
    public function operate()
    {
        $operateTime = input('operate_time');

        $where = [];

        if (!empty($operateTime)) {
            $where[] = ['operate_time', 'between', [$operateTime, $operateTime. ' 23:59:59']];
        }

        $operateModel = new OperateLog();
        $list = $operateModel->getOperateLogList($where);


        $this->assign([
            'res' => $list
        ]);
        return view('',['title'=>'操作日志']);
    }

    public function delete()
    {
        $id = input('id');
        $type = input('type');
        if($type) {
            $db = new LoginLog();
        } else {
            $db = new OperateLog();
        }
        $res = $db->destroy($id);
        if($res){
            return json(['msg'=>'删除成功！','status'=>1]);
        }else{
            return json(['msg'=>'删除失败！','status'=>0]);
        }
    }
    public function dels()
    {
        $ids = input('post.log_id/a');
        $type = input('type');
        if(empty($ids)){
            $this->error('未选中任何内容！');
        }
        if($ids){
            if($type) {
                LoginLog::destroy($ids);
            } else {
                OperateLog::destroy($ids);
            }
            $this->success('删除成功！');
        }
    }

    //清空数据表
    public function truncateTable()
    {
        $db_name = input('db_name','operate_log');
        $sql = "TRUNCATE TABLE `". config('database.prefix') . $db_name ."`";
        DB::name($db_name)->execute($sql);
        return json(['msg'=>'清空数据表成功！','status'=>1]);
    }
}
