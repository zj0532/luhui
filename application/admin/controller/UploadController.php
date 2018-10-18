<?php
// 商户后台上传控制器
// User: tianyu
// Date: 18/4/1
// Time: 下午6:48
namespace app\admin\controller;

use think\Controller;

class UploadController extends Controller
{
    //审核页面
    public function upload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('userfile');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            //$info = $file->move(ROOT_PATH . 'public/static/user/uploads');//这种上传是新建个年月日目录的，也就是图片名带个年月日的目录
			$info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/user/uploads');//这种上传是只有文件名的，没有年月日目录
            if ($info) {
                // 成功上传后 获取上传信息
                // 输出 jpg
                $path = config('user_upload_path') . $info->getSaveName();
                $fn = $info->getSaveName();
                return show(200,"上传成功",["img"=>$path,"newFn"=>$fn],200);
            } else {
                // 上传失败获取错误信息
                return show(500,$file->getError(),[],200);
            }
        }else{
          return show(500,"上传失败",[],200);
        }
    }
}
