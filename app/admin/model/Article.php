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
class Article extends Model
{
    public function keySelect($key)
    {
        $join = [
            ['__CATE__ c','c.id=a.cid']
        ];
        $map = [];
        $filed = "a.*,c.catename";
        if($key) {
            $map['a.desc|a.title|a.keywords|a.content']=['like','%'.$key.'%'];
        }
        $res = $this->alias('a')->field($filed)->order('update_time desc,create_time desc')->join($join)->where($map)->paginate(10);
        return $res;
    }
    protected static function init()
    {
 /*       Article::event('before_insert',function($data){
            if($_FILES['pic']['tmp_name']){
                $file=request()->file('pic');
                if($file){
                    //图片上传的路径
                    $info=$file->validate(['size'=>4145728,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
                    if($info){
                        //图片路径
                        $info->getSaveName();
                        $pic='./uploads'.DS.date('Ymd').'/'.$info->getFilename();
                        $image = \think\Image::open($info);
                        $image->thumb(600,600)->save($pic);
                        $str=substr($pic,1);
                        $data['pic'] = $str;
                    }
                }
            }
        });
        Article::event('before_update',function($data){
            if($_FILES['pic']['tmp_name']){
                $arts=Article::find($data->id);
                $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['pic'];
                //判断文件是否存在file_exists
                if(file_exists($picpath)){
                    @unlink($picpath);
                }
                $file=request()->file('pic');
                $info=$file->validate(['size'=>4145728,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
                if($info){
                    //图片路径
                    $info->getSaveName();
                    $pic='./uploads'.DS.date('Ymd').'/'.$info->getFilename();
                    $image = \think\Image::open($info);
                    $image->thumb(600,600)->save($pic);
                    $str=substr($pic,1);
                    $data['pic'] = $str;
//                    $data['pic']=DS.'uploads'.DS.date('Ymd').'/'.$info->getFilename();
                }
            }
        });
      */
        Article::event('before_delete',function($data){
            $arts=Article::find($data->id);
            $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['del_url'];
            //判断文件是否存在file_exists
            if(file_exists($picpath)){
                @unlink($picpath);
            }
        });
    }
}
