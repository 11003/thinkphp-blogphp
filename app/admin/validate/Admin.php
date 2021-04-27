<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'username'=>'require|max:15|unique:admin',
        'password'=>'require|confirm',
    ];
    protected $message=[
        'username.require'  =>  '登录账号不能为空！',
        'username.unique'   =>  '登录账号重复！',
        'username.max'      =>  '登录账号不能超过15字符！',
        'password.require'  =>  '密码不能为空！',
        'password.confirm'  =>  '密码不一致！',
    ];

    protected $scene = [
        'edit'  =>  'username',
    ];
}