<?php
/**
 * User: Lh
 * Date: 2019/4/23
 * Time: 14:36
 */

namespace app\admin\validate;


use think\Validate;

class AuthGroup extends Validate
{
    protected $rule = [
        'title'=>'require|unique:auth_group',
    ];
    protected $message=[
        'title.require'  =>  '角色组名称不能为空！',
        'title.unique'   =>  '该角色组已经存在！',
    ];
}