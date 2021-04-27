<?php

namespace app\admin\model;

use think\Model;

class OperateLog extends Model
{
    protected $table = 'be_operate_log';

    /**
     * 写操作日志
     * @param $param
     * @return array
     */
    public function writeLog($param)
    {
        try {

            $this->insert($param);
        } catch (\Exception $e) {
            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '写入成功');
    }

    /**
     * 获取角色列表
     * @param $where
     * @return array
     */
    public function getOperateLogList($where)
    {
        try {

            $list = $this->where($where)->order('log_id', 'desc')->paginate(10);
            foreach($list as $k=>$v){
                $list[$k]['unlimit_operate_desc'] = $v['operate_desc'];
                $list[$k]['operate_desc'] = subtext($v['operate_desc'],50);
            }
            return $list;

        }catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
