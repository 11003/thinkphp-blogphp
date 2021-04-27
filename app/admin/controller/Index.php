<?php
namespace app\admin\controller;
use tool\Log;
use think\Db;

class Index extends Base
{
    public function index()
    {
        $articleCount = $this->getDBCount('article');
        $cateCount = $this->getDBCount('cate');
        $commentCount = $this->getDBCount('comment');
        $data = [
            'title'=>'博客后台',
            'articleCount'=> $articleCount,
            'cateCount'=> $cateCount,
            'commentCount'=> $commentCount,
        ];
        return view('',$data);
    }
    /**
     * 清除缓存
     */
    public function clear() {
        if (delete_dir_file()) {
            Log::write(session('username').'清除了缓存数据');
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
    private function getDBCount($db)
    {
        return DB::name($db)->count('id');
    }
}
