<?php
namespace app\admin\validate;
use think\Validate;
class Conf extends Validate
{
    protected $rule = [
        'cn_name'=>'require|max:15|unique:conf',
        'en_name'=>'require|max:15|unique:conf',
        'type'   =>'require'
    ];
    protected $message=[
        'cn_name.require'  =>  '中文名称不能为空！',
        'cn_name.unique'   =>  '中文名称重复！',
        'cn_name.max'      =>  '中文名称不能超过15字符！',
        'en_name.require'  =>  '英文名称不能为空！',
        'en_name.unique'   =>  '英文名称重复！',
        'en_name.max'      =>  '英文名称不能超过15字符！',
        'type'             =>  '配置类型不能为空！'
    ];
}