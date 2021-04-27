<?php
/**
 * User: Sonder
 * Date: 2019/3/10
 * Time: 23:51
 */
use PHPMailer\PHPMailer\PHPMailer;
/**
 * 发送邮件
 */
function send_email($address,$cid,$aid,$title,$body,$user_name,$user_comment)
{
    $smtpSetting = config('smtp_setting');

    $mail        = new PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = 3;
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet = 'UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);
    //提交链接
    $link = $cid ? $smtpSetting['link']."/page/关于我?cid=41" : $smtpSetting['link']."/post/{$aid}?cid={$cid}";
    // 组装a标签链接
//    $a_tag = "<a href='{$link}'>{$link}</a>";
    // 设置邮件正文
    $mail->Body = contents($user_name,$title,$body,$link,$user_comment);
    // 设置邮件头的From字段。
    $mail->From = $smtpSetting['from'];
    // 设置发件人名字
    $mail->FromName = $smtpSetting['from'];
    // 填写发送人的邮箱，和主题标题
    $mail->setFrom($smtpSetting['address'], $smtpSetting['from']);
    // 填写回复的邮箱，和主题标题
    $mail->addReplyTo($smtpSetting['address'],$smtpSetting['from']);
    // 设置邮件标题
    $mail->Subject = $smtpSetting['title'];
    // 设置SMTP服务器。
    $mail->Host ='smtp.qq.com;';
    //by Rainfer
    // 设置SMTPSecure。
    $mail->SMTPSecure = 'ssl';
    // 设置SMTP服务器端口。
    $mail->Port = "465";
    // 设置为"需要验证"
    $mail->SMTPAuth    = true;
    $mail->SMTPAutoTLS = false;
    $mail->Timeout     = 10;
    // 设置用户名和密码。
    $mail->Username = $smtpSetting['username'];
    $mail->Password = $smtpSetting['password'];
    // 发送邮件。
    if (!$mail->Send()) {
        $mailError = $mail->ErrorInfo;
        if($smtpSetting['debug']){
            echo 'Mailer Error: ' . $mailError . '<br>';
        }
        return ["error" => 1, "message" => $mailError];
    } else {
        return ["error" => 0, "message" => "success"];
    }
}
function contents($user_name,$title,$body,$link,$user_comment)
{
    return '<div style="background: #f8f8f8; color: #666; font-size: 12px;">
    <div style="width: 570px; margin: 0 auto; background: #fff; padding: 25px 70px; border-top: 30px solid #1abc9c;">
        <div style="text-align: center; margin-bottom: 40px; line-height: 1.8em;">
            <h1 style="color: #333;">'. config('my_web.name') .'</h1></div>
        <p style="font-size: 18px; color: #333;">'.$user_name.'，您好！</p>您曾在《
        <a target="_blank" href="' .$link. '">'.$title.'</a>》上发表评论:
        <br />&nbsp;&nbsp;&nbsp;&nbsp;
        <p style="border: 1px solid #eee; padding: 20px; margin: 15px 0;">"'.strip_tags($user_comment).'"</p>
        <span>我给您的回应：</span>
        <br />&nbsp;&nbsp;&nbsp;&nbsp;
        <a style="display: inline-block;padding: 20px; margin: 15px 0;" href="' . $link . '">'.$body.'</a>
        <br />&nbsp;&nbsp;&nbsp;&nbsp;
        <p class="footer" style="border-top: 1px solid #DDDDDD; padding-top: 6px; margin-top: 15px; color: #838383; text-align: center;">你可以点击此链接
            <a target="_blank" href="'.$link.'">查看完整內容</a>|欢迎再次来访
            <a href="'. config('my_web.address') .'">"'.config('my_web.name').'"</a>
        </p>
        <a style="display: block; width: 400px; height: 40px; background: #1abc9c; margin: 25px auto 40px; font-size: 16px; line-height: 40px; letter-spacing: 3px; color: #f8f8f8; text-align: center; text-decoration: none;" href="'. config('my_web.address') .'" target="_blank">发现更多精彩&gt;&gt;</a>
        <p style="text-align: center;color: #bbb;margin-top: 40px;">「'. config('my_web.name') .'」 '.date('Y').'年 by Copyright.</p></div>
</div>';
}

/**
 * 忘记密码发送邮件
 */
function send_email_by_forgotPass($pass)
{
    $smtpSetting = config('smtp_setting');

    $mail        = new PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = 3;
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet = 'UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $address = $smtpSetting['address'];
    $mail->AddAddress($address);
    // 设置邮件正文
    $mail->Body = "您好，初始密码为：" . $pass . "<br/><br/><br/><i>*如果不是您的邮件请忽略它。祝您生活愉快</i>";
    // 设置邮件头的From字段。
    $mail->From = $smtpSetting['from'];
    // 设置发件人名字
    $mail->FromName = $smtpSetting['from'];
    // 填写发送人的邮箱，和主题标题
    $mail->setFrom($smtpSetting['address'], $smtpSetting['from']);
    // 填写回复的邮箱，和主题标题
    $mail->addReplyTo($smtpSetting['address'],$smtpSetting['from']);
    // 设置邮件标题
    $mail->Subject = "忘记密码";
    // 设置SMTP服务器。
    $mail->Host ='smtp.qq.com;';
    //by Rainfer
    // 设置SMTPSecure。
    $mail->SMTPSecure = 'ssl';
    // 设置SMTP服务器端口。
    $mail->Port = "465";
    // 设置为"需要验证"
    $mail->SMTPAuth    = true;
    $mail->SMTPAutoTLS = false;
    $mail->Timeout     = 10;
    // 设置用户名和密码。
    $mail->Username = $smtpSetting['username'];
    $mail->Password = $smtpSetting['password'];
    // 发送邮件。
    if (!$mail->Send()) {
        $mailError = $mail->ErrorInfo;
        if($smtpSetting['debug']){
            echo 'Mailer Error: ' . $mailError . '<br>';
        }
        return ["error" => 1, "message" => $mailError];
    } else {
        return ["error" => 0, "message" => "success"];
    }
}
/**
 * 根据ip定位
 * @param $ip
 * @return string
 * @throws Exception
 */
function getLocationByIp($ip)
{
    $ip2region = new \Ip2Region();
    $info = $ip2region->btreeSearch($ip);

    $info = explode('|', $info['region']);

    $address = '';
    foreach($info as $vo) {
        if('0' !== $vo) {
            $address .= $vo . '-';
        }
    }

    return rtrim($address, '-');
}
