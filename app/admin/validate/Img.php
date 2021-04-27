<?php
namespace app\admin\validate;
use think\Validate;
class Img extends Validate
{
    protected $rule = [
        'desc'=>'require',
    ];
    protected $message=[
        'desc.require'  =>  '描述不能为空！',
    ];
    protected $scene = [
        'edit' => 'desc',
    ];
}