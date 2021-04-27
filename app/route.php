<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::group([ 'method'=> 'get','prefix' => 'admin'],[
    '/logout' => '/Login/logout',
    '/login' => '/Login/login',
]);
//文章
Route::rule('/search','index/Search/index');
Route::group([ 'method'=> 'get','prefix' => 'index'],[
    '/' => '/Index/index',
    'artlist/:cid' => '/Artlist/index',
    'page/:cid' => '/Page/index',
    'imglist/:cid' => '/Imglist/index',
    'article/:cid/:id' => '/Article/index',
    'setincart' => '/Article/setIncArt',
    'resume' => '/Index/resume'
]);
Route::group([ 'method'=> 'post','prefix' => 'index'],[
    'like/:aid/:cid' => '/Article/like',
]);
//api 前端
Route::group([ 'method'=> 'get|post','prefix' => 'api'],[
    'api/indexlist' => '/Index/index',
    'api/index_video' => '/Index/indexVideo',
    'api/artlist' => '/Index/artlist',
    'api/timelist' => '/Index/timelist',
    'api/catename' => '/Index/getCateNameByCid',
    'api/hot' => '/Index/hot',
    'api/like_article' => '/Index/like_article',
    'api/nav' => '/Index/navigation',
    'api/conf' => '/Index/conf',
    'api/link' => '/Index/link',
    'api/about' => '/Index/aboutMe',
    'api/timeline' => '/Index/timeline',
    'api/comment' => '/Index/comment',
    'api/add_comment' => '/Index/addComment',
    'api/add_reply' => '/Index/addReply',
    'api/page' => '/Index/page',
    'api/unlock' => '/Index/unlockArticlePass',
]);
Route::any('api/post','api/Index/post',['method'=>'get|post']);

//api 后端（get）
Route::group([ 'method'=> 'get|post','prefix' => 'api'],[
    'api/leftNav' => '/Admin/leftNav',
    'api/articleList' => '/Admin/article_list',
    'api/getInfo' => '/Admin/getInfo',
    'api/userLogin' => '/Admin/userLogin',
    'api/userLogout' => '/Admin/userLogout',
    'api/getUserInfo' => '/Admin/getUserInfo',
]);
// api 后端操作（set）
Route::group([ 'method'=> 'get|post','prefix' => 'api'],[
    'api/upload' => '/Admin/upload_img',
    'api/editorUploadImg' => '/Admin/editorUploadImg',
    'api/deleteImg' => '/Admin/delete_img',
]);
