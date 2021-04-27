<?php
namespace app\admin\validate;
use think\Validate;
class Timeline extends Validate
{
    protected $rule = [
        'title'=>'require|max:45',

    ];
    protected $message=[
        'title.require'  =>  '时间轴标题不能为空！',
        'title.max'      =>  '时间轴标题不能超过45字符！',
    ];
}
