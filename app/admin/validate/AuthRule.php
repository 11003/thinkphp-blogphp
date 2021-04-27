<?php
/**
 * User: Lh
 * Date: 2019/4/23 23:41
 */

namespace app\admin\validate;


use think\Validate;

class AuthRule extends Validate
{
    protected $rule = [
        'title'=>'require|unique:auth_rule',
        'name' =>'require|unique:auth_rule',
    ];
    protected $message=[
        'title.require'  =>  '权限名称不能为空！',
        'title.unique'   =>  '权限名称已经存在！',
        'name.require'   =>  '（控/方）不能为空！',
        'name.unique'    =>  '（控/方）已经存在！',
    ];
}