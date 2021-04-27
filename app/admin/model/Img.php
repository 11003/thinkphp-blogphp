<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/9/23
 * Time: 19:19
 */
namespace app\admin\model;
use think\Model;
use think\Db;
use think\Image;
class Img extends Model
{
    public function selects()
    {
        $res = $this->order('sort DESC')->paginate(10);
        return $res;
    }

//    protected static function init()
//    {
//        Img::event('before_insert',function($data){
//            if($_FILES['pic']['tmp_name']){
//                $file=request()->file('pic');
//                if($file){
//                    //图片上传的路径
//                    $info=$file->validate(['size'=>4145728,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
//                    if($info){
//                        //图片路径
//                        $data['pic']=DS.'uploads'.DS.date('Ymd').'/'.$info->getFilename();
//                    }
//                }
//            }
//        });
//        Img::event('before_update',function($data){
//            if($_FILES['pic']['tmp_name']){
//                $arts=Img::find($data->id);
//                $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['pic'];
//                //判断文件是否存在file_exists
//                if(file_exists($picpath)){
//                    @unlink($picpath);
//                }
//                $file=request()->file('pic');
//                $info=$file->validate(['size'=>4145728,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
//                if($info){
//                    //图片路径
//                    $data['pic']=DS.'uploads'.DS.date('Ymd').'/'.$info->getFilename();
//                }
//            }
//        });
//        Img::event('before_delete',function($data){
//            $arts=Img::find($data->id);
//            $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['pic'];
//            //判断文件是否存在file_exists
//            if(file_exists($picpath)){
//                @unlink($picpath);
//            }
//        });
//    }
}