<?php
/**
 * User: Administrator
 * Date: 2019/3/10
 * Time: 23:51
 */

$index_address = "http://index.musclewiki.cn";
$blog_address = "http://blog.musclewiki.cn";
return [
    //登陆次数
    'login_error_num' => 3,
    //备份数据地址
    'back_path' => APP_PATH .'../back/',
    //管理员回复不需要登录
    'reply_rule' => '!~:',
    //api规则
    'api_rule' => '4atpi0t10ny',
    //加密串
    'salt' => 'wZPb~yxvA!ir01&Z',
    //不需要权限
    'notCheck' => [
        'index/index',//首页
        'login/logout',//退出
        'index/clear'//清除缓存
    ],
    'my_web' => [
        'address' => $index_address,
        'blog_address' => $blog_address,
        'name' => '刘海 | LH-Blog'
    ],
    'smtp_setting' => [
        // 邮件标题
        "title" => "博客消息",
        //设置邮件头的From字段
        'from' => '通知',
        // SMTP 用户名，如果是QQ邮箱申请的则填写QQ邮箱
        'username' => '123@qq.com',
        // SMTP 密码，如果是QQ邮箱申请的则填写开通SMTP服务后生成的密码
        'password' => 'xxx',
        // SMTP 邮箱地址，如果是QQ邮箱申请的则填写QQ邮箱
        'address'=> '123@qq.com',
        // 分享地址
        'link' => $blog_address,
        // 邮件内容，{{link}} 为表白链接的占位符，可随意更改位置，系统自动替换为表白链接。
        "body" => "测试",
        // 邮件发送成功返回
        "success" => "邮件发送成功",
        // 邮件发送失败返回
        "failed" => "邮件发送失败！因为当前人数太多，邮件发送频率高被限制，不过系统会在稍后自动重新发送邮件，请放心，联系站长QQ：814029073<br>",
        // 失败的时候是否返回错误的详细信息，英文的信息，带错误码，用于程序调试，不显示就改为false
        "debug" => true
    ],
    'auth_config' => [
        'auth_on'           => true,                      // 认证开关
        'auth_type'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'auth_group',        // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_rule'         => 'auth_rule',         // 权限规则表
    ]
];
