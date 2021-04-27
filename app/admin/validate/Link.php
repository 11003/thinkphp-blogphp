<?php
namespace app\admin\validate;
use think\Validate;
class Link extends Validate
{
    protected $rule = [
        'name'=>'require|max:25|unique:link',
        'url'=>'require|unique:link',
    ];
    protected $message=[
        'name.require'  =>  '链接名称不能为空！',
        'name.unique'   =>  '链接名称重复！',
        'url.unique'   =>  '链接网址重复！',
        'name.max'      =>  '链接名称不能超过25字符！',
        'url.require'  =>  '链接地址不能为空！',
    ];
}