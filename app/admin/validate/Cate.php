<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate
{
    protected $rule = [
        'catename'=>'require|max:100|unique:cate',

    ];
    protected $message=[
        'catename.require'  =>  '栏目名称不能为空！',
        'catename.unique'   =>  '栏目名称重复！',
        'catename.max'      =>  '栏目名称不能超过100字符！',
    ];
}