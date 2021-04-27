<?php
/**
 * User: Lh
 * Date: 2019/9/7 0:02
 */

namespace app\api\controller;


use think\Controller;

class CommonApi extends Controller
{
    const RULE_FRIEND = 1; //邻居
    const RULE_ADMIN = 2; //管理员

    public function _initialize()
    {

    }
    protected function rule($rule_number,$address)
    {
        switch ($rule_number) {
            case self::RULE_ADMIN:
                return '<a class="comment_ordinary comment_ordinary_user_admin">博主</a>';
                break;
            case self::RULE_FRIEND:
                return '<a class="comment_ordinary comment_ordinary_user_friend" title="朋友">'.$address.'</a>';
                break;
            default:
                return '<a class="comment_ordinary comment_ordinary_user" title="普通访客">'.$address.'</a>';
        }
    }
}
