<?php
error_reporting(E_ERROR | E_PARSE );
use app\admin\controller\Auth;

/**
 * 打印方式
 * @param $var
 */
function p($var) {
    echo "<pre>" . print_r($var, true) . "</pre>";
}

/**
 * src替换为data-src
 * @param $content
 * @return string|string[]|null
 */
function img_lazy($content="",$suffix="data:image/gif;base64,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") {
/*    $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/" */;
//    return preg_replace($pregRule, '<img src="'.$suffix.'" data-src="${1}">', $content);
    return preg_replace('/img src=/', 'img src="'.$suffix.'" data-src=${1}', $content);
}

/**
 * 获取客户端IP
 * @param int $type
 * @param bool $adv
 * @return mixed
 */
function get_client_ip($type=0,$adv=false)
{
    return request()->ip($type,$adv);
}

/**
 * 控制器返回格式
 * @param $msg
 * @param $status
 * @param string $data
 * @return \think\response\Json
 */
function jsonData($msg,$status,$data = '')
{
    return json(['code' => $status, 'data' => $data, 'msg' => $msg ]);
}

/**
 * 截取字符串
 * @param $text
 * @param $length
 * @param string $replace
 * @param string $encoding
 * @return string
 */
function subtext($text, $length, $replace='...', $encoding='UTF-8'){
    $text = strip_tags($text);
    if ($text && mb_strlen($text, $encoding)>$length) {
        return mb_substr($text, 0, $length, $encoding).$replace;
    }
    return $text;
}


/**
 * 检查权限
 * 功能
 * @param $model
 * @return bool
 */
function authCheck($model)
{
    $uid = session('id');
    $auth = new Auth();
    if(in_array($model,config('notCheck')) || $uid == 1){
        return true;
    }
    if($auth->check($model,$uid)){
        return true;
    }
    return false;
}

/**
 * 检查权限
 * 导航列表
 * @param $model
 * @return bool
 */
function authList($model)
{
    $uid = session('id');
    $auth = new Auth();
    if(in_array($model,config('notCheck')) || $uid == 1){
        return true;
    }
    if($auth->check($model,$uid)){
        return true;
    }
    return false;
}

/**
 * 对象转换成数组
 * @param $obj
 * @return mixed
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), true);
}


/**
 * 生成操作按钮
 * @param array $operate 操作按钮数组
 * @return string
 */
function showOperate($operate = [])
{
    if(empty($operate)){
        return '';
    }
    $option = '';
    foreach($operate as $key=>$vo){
        if(authCheck($vo['auth'])){
            $option .= '<a style="margin-right:5px" href="javascript:void(0)" class="btn btn-xs '. $vo['class'] .'" '. $vo['attr'] .'="'. $vo['url'] .'"><i class="fa '.$vo['icon'].'"></i>'. $key .'</a>';
        }
    }
    return $option;
}

/**
 * 驼峰转下划线
 * @param $str
 * @return string|string[]|null
 */
function humpToLine($str){
    return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $str), "_"));
}

/**
 * 整理菜单住方法
 * @param $param
 * @return array
 */
function prepareMenu($param)
{
    $param = objToArray($param);
    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo){

        if(0 == $vo['pid']){
            $vo['href'] = '#';
            $parent[] = $vo;
        }else{
            // 不是顶级栏目并且是列表
            $vo['href'] = url($vo['name']); //跳转地址
            $child[] = $vo;

        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){

            if($v['pid'] == $vo['id'] && $vo['is_menu'] == 2){
                $parent[$key]['child'][] = $v;
            }
        }
    }
    unset($child);

    return $parent;
}


/**
 * 将图片替换为文字
 * @param $replacement
 * @param $string
 * @return null|string|string[]
 */
function isIncludedImg($replacement,$string)
{
    $pattern="/<[img|IMG].*?src=[\'\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
    return preg_replace($pattern,$replacement,$string);
}
/**
 * model返回标准函数
 * @param $code
 * @param $data
 * @param $msg
 * @return array
 */
function modelReMsg($code, $data, $msg) {
    return ['code' => $code, 'data' => $data, 'msg' => $msg];
}

/**
 * 统一返回信息
 * @param $code
 * @param $data
 * @param $msg
 * @return array
 */
function msg($code, $data, $msg)
{
    return compact('code', 'data', 'msg');
}

/**
 * 循环删除目录和文件
 * @param string $path
 * @param bool $delDir
 * @return bool
 */
function delete_dir_file($path = '', $delDir = true)
{
    $path   = !empty($path) ? $path : RUNTIME_PATH;
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..") {
                if (is_dir($path . DIRECTORY_SEPARATOR . $item)) {
                    @chmod($path . DIRECTORY_SEPARATOR . $item, 0777);
                    delete_dir_file($path . DIRECTORY_SEPARATOR . $item, $delDir);
                } else {
                    unlink($path . DIRECTORY_SEPARATOR . $item);
                }
            }
        }
        closedir($handle);
        if ($delDir) {
            @rmdir($path);
            return true;
        }
    } else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return false;
        }
    }
}
/**
 * 人性化时间显示
 * @param $time
 * @return false|string
 */
function transfer_time($time)
{
    $time = (int) substr($time, 0, 10);
    $int = time() - $time;
    if ($int <= 2){
        $str = sprintf('刚刚', $int);
    }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
    }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
    }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
    }elseif ($int < 1728000){
        $str = sprintf('%d天前', floor($int / 86400));
    }else{
        $str = date('Y年m月d日 H:i', $time);
    }
    return $str;
}

/**
 * 解析备份sql文件
 * @param $file
 * @return array
 */
function analysisSql($file)
{
    // sql文件包含的sql语句数组
    $sqls = array ();
    $f = fopen ( $file, "rb" );
    // 创建表缓冲变量
    $create = '';
    while ( ! feof ( $f ) ) {
        // 读取每一行sql
        $line = fgets ( $f );
        // 如果包含空白行，则跳过
        if (trim ( $line ) == '') {
            continue;
        }
        // 如果结尾包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)，
        if (! preg_match ( '/;/', $line, $match ) || preg_match ( '/ENGINE=/', $line, $match )) {
            // 将本次sql语句与创建表sql连接存起来
            $create .= $line;
            // 如果包含了创建表的最后一句
            if (preg_match ( '/ENGINE=/', $create, $match )) {
                // 则将其合并到sql数组
                $sqls [] = $create;
                // 清空当前，准备下一个表的创建
                $create = '';
            }
            // 跳过本次
            continue;
        }

        $sqls [] = $line;
    }
    fclose ( $f );

    return $sqls;
}

/**
 * php防注入和XSS攻击通用过滤
 * @param $html
 * @return mixed
 */
function string_remove_xss($html) {
    preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

    $searchs[] = '<';
    $replaces[] = '&lt;';
    $searchs[] = '>';
    $replaces[] = '>';

    if ($ms[1]) {
        $allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote';
        $ms[1] = array_unique($ms[1]);
        foreach ($ms[1] as $value) {
            $searchs[] = "&lt;".$value."&gt;";

            $value = str_replace('&amp;', '_uch_tmp_str_', $value);
            $value = string_htmlspecialchars($value);
            $value = str_replace('_uch_tmp_str_', '&amp;', $value);

            $value = str_replace(array('\\', '/*'), array('.', '/.'), $value);
            $skipkeys = array('onabort','onactivate','onafterprint','onafterupdate','onbeforeactivate','onbeforecopy','onbeforecut','onbeforedeactivate',
                'onbeforeeditfocus','onbeforepaste','onbeforeprint','onbeforeunload','onbeforeupdate','onblur','onbounce','oncellchange','onchange',
                'onclick','oncontextmenu','oncontrolselect','oncopy','oncut','ondataavailable','ondatasetchanged','ondatasetcomplete','ondblclick',
                'ondeactivate','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onerror','onerrorupdate',
                'onfilterchange','onfinish','onfocus','onfocusin','onfocusout','onhelp','onkeydown','onkeypress','onkeyup','onlayoutcomplete',
                'onload','onlosecapture','onmousedown','onmouseenter','onmouseleave','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel',
                'onmove','onmoveend','onmovestart','onpaste','onpropertychange','onreadystatechange','onreset','onresize','onresizeend','onresizestart',
                'onrowenter','onrowexit','onrowsdelete','onrowsinserted','onscroll','onselect','onselectionchange','onselectstart','onstart','onstop',
                'onsubmit','onunload','javascript','script','eval','behaviour','expression','style','class');
            $skipstr = implode('|', $skipkeys);
            $value = preg_replace(array("/($skipstr)/i"), '.', $value);
            if (!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
                $value = '';
            }
            $replaces[] = empty($value) ? '' : "<" . str_replace('&quot;', '"', $value) . ">";
        }
    }
    $html = str_replace($searchs, $replaces, $html);

    return $html;
}
//php防注入和XSS攻击通用过滤
function string_htmlspecialchars($string, $flags = null) {
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = string_htmlspecialchars($val, $flags);
        }
    } else {
        if ($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '>'), $string);
            if (strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if (PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if (!defined('CHARSET') || (strtolower(CHARSET) == 'utf-8')) {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }

    return $string;
}

function getAddressByIp($ip = ''){
    if(empty($ip)){
        return '请输入IP地址';
    }
    $url="http://restapi.amap.com/v3/ip?key=4a218d0d82c3a74acf019b701e8c0ccc&ip=".$ip;
    $ipinfo=json_decode(file_get_contents($url));
    $location = $ipinfo->{'city'};
    $s = $location?$location:"本地或未知";
    return $s;
}
function LookNumbers($num) {
    if($num < 1000) {
        return $num;
    } else if($num >=1000 && $num < 10000){
        return round($num/1000,1).'k';
    } else if ($num >= 10000) {
        return round($num/10000,2).'w';
    } else {
        return $num;
    }
}
function sc_send(  $title , $desc = '' , $key = 'SCU75298T984eb6895f3fb86b0b2e766fc335ddc35e0db8542681c'  ) {
    $postdata = http_build_query(
        array(
            'text' => $title,
            'desp' => $desc
        )
    );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context  = stream_context_create($opts);
    return $result = file_get_contents('https://sc.ftqq.com/'.$key.'.send', false, $context);
}
// 过滤emoji表情
function filter_Emoji($str) {
    $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);

    return $str;
}
if (!function_exists('letter_avatar')) {
    /**
     * 首字母头像
     * @param $text
     * @return string
     */
    function letter_avatar($text)
    {
        $total = unpack('L', hash('adler32', $text, true))[1];
        $hue = $total % 360;
        list($r, $g, $b) = hsv2rgb($hue / 360, 0.3, 0.9);

        $bg = "rgb({$r},{$g},{$b})";
        $color = "#ffffff";
        $first = mb_strtoupper(mb_substr($text, 0, 1));
        $src = base64_encode('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="100" width="100"><rect fill="' . $bg . '" x="0" y="0" width="100" height="100"></rect><text x="50" y="50" font-size="50" text-copy="fast" fill="' . $color . '" text-anchor="middle" text-rights="admin" alignment-baseline="central">' . $first . '</text></svg>');
        $value = 'data:image/svg+xml;base64,' . $src;
        return $value;
    }
}
if (!function_exists('hsv2rgb')) {
    function hsv2rgb($h, $s, $v)
    {
        $r = $g = $b = 0;

        $i = floor($h * 6);
        $f = $h * 6 - $i;
        $p = $v * (1 - $s);
        $q = $v * (1 - $f * $s);
        $t = $v * (1 - (1 - $f) * $s);

        switch ($i % 6) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
            case 5:
                $r = $v;
                $g = $p;
                $b = $q;
                break;
        }

        return [
            floor($r * 255),
            floor($g * 255),
            floor($b * 255)
        ];
    }
}

/**
 * 备份数据表按钮
 * @param array $operate
 * @return string
 */
function showDataOperate($operate = [])
{
    if(empty($operate)){
        return '';
    }
    $option = '';
    foreach($operate as $key=>$vo){
        if(authCheck($vo['auth'])){
            $option .= ' <a href="' . $vo['href'] . '"><button type="button" class="btn btn-' . $vo['btnStyle'] . ' btn-sm">'.
                '<i class="' . $vo['icon'] . '"></i> ' . $key . '</button></a>';
        }
    }

    return $option;
}
/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * curl网络api请求
 * @param $url
 * @return bool|string
 */
function get_Curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);  //设置访问的url地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
    $result =  curl_exec($ch);
    curl_close ($ch);
    return $result;
}

/**
 * 每日一文
 * @return string
 */
function getDayArticle()
{
    $url = 'https://interface.meiriyiwen.com/article/today?dev=1';
    $json = get_Curl($url);
    $data = json_decode($json,true); // json转为数组
    return '《' . $data['data']['title'] . '》<br/><br/>作者：' . $data['data']['author'] .'<br/><br/>'. $data['data']['content'];
}
