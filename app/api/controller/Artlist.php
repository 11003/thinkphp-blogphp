<?php


namespace app\api\controller;


use app\api\model\ArtlistModel;

class Artlist extends CommonApi
{
    public function page_list($data)
    {
        $list = new ArtlistModel();
        $limit = intval($data['limitNumber']); // 一页9个
        $cid = isset($data['cid']) ? $data['cid'] : "";
        $page = 1;  // 0
        if (!empty($data)) {
            // 展示
            $selectResult = $list->getListByWhere($page, $data, $cid);
            // 总数
            if(!empty($data['searchValue']) && isset($data['searchValue'])){
                $res['count'] = $list->getSearchCount($page, $data);
            } else {
                $res['count'] = count($selectResult);
            }
            // 获取共有多少页数
            $total_page = floor($res['count'] / $limit);
            $res['total_page'] = $total_page;
            // 每个用户信息 二维数组
            $res['rows'] = $selectResult;
            return json($res);
        }
    }
}
