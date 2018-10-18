<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3 0003
 * Time: 16:39
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

class NewsController extends Controller
{
    //公司新闻 列表
    public function get_news_list()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }

        $j["sidebar"] = 4;
        $data=input();
        $data['page']=intval($data['page'])?intval($data['page']):1;
        $pagesize=10;
        $page=$data['page'];
        $start=($page-1)*$pagesize;
        $step=$pagesize;

        $sqlnum = "select count(*) num from base_news  ";
        $resultnum=Db::query($sqlnum);
        //总记录数
        $data["countnum"] = $resultnum[0]['num'];
        //总页数
        $pagenumber=floor($resultnum[0]['num']/$pagesize)+1;
        $data['countpage']=$pagenumber;
        //上一页
        $data['shangpage']=intval($page)>1?intval($page)-1:1;
        //下一页
        $data['xiapage']=intval($page)<$pagenumber?intval($page)+1:intval($page);

        $j["data"] = $data;


        $sql="SELECT * FROM base_news order by ns_id desc limit " . $start . ", " . $step;
        $j['list']=Db::query($sql);
        $j['imgpath']=config("news_upload_path");
        return view('news',$j);
    }

    //新增公司新闻 页面
    public function get_news_add()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data
        $j["sidebar"] = 15;
        //print_r($j);exit();
        return view('news_add',$j);
    }
    //新增公司新闻 提交处理
    public function post_news_add()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input('post.');//通过助手将POST所有数据交给 data
        //print_r($data);
        //$files = input('FILES');//通过助手将POST所有数据交给 data
        //print_r($_FILES);


        // 获取表单上传文件 例如上传了001.jpg
        $imgUp=0;
        $file = request()->file('ns_img');
        $imgname = "";
        // 移动到框架应用根目录/static/uploads/gonggao/ 目录下
        if ($file)
        {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/news/');
            if ($info)
            {
                // 成功上传后 获取上传信息
                // 输出 jpg
                $imgname = $info->getSaveName();
                $imgUp=1;
            }
            else
            {
                // 上传失败获取错误信息
                return show(500,"图片上传失败，请重试",[],200);



            }
        }
        $data['ns_title']=addslashes($data['ns_title']);
        $data['ns_descript']=addslashes($data['ns_descript']);
        if($imgname)
        {
            $sql="insert into base_news (ns_title,ns_img,ns_intime,ns_descript,ns_content) VALUES
		  ('".$data['ns_title']."','".$imgname."','".time()."','".$data['ns_descript']."','".$data['editor1']."')";
        }
        else
        {
            $sql="insert into base_news (ns_title,ns_intime,ns_descript,ns_content) VALUES
		  ('".$data['ns_title']."','".time()."','".$data['ns_descript']."','".$data['editor1']."')";
        }
        Db::execute($sql);

        $tiaozhuanlujing="/admin/news/1";
        return redirect($tiaozhuanlujing);
    }

    //编辑公司新闻 页面
    public function get_news_edit()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data

        $sql="select * from base_news where ns_id='".$data['id']."'";
        $aa=Db::query($sql);
        $j['list']=$aa[0];
        $j['id']=$data['id'];
        $j['page']=$data['page'];
        $j['imgpath']=config("news_upload_path");
        $j["sidebar"] = 15;
        //print_r($j);exit();
        return view('news_edit',$j);
    }
    //编辑公司新闻 提交处理
    public function post_news_edit()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input('post.');//通过助手将POST所有数据交给 data
        //print_r($data);exit();

        // 获取表单上传文件 例如上传了001.jpg
        $imgUp=0;
        $file = request()->file('ns_img');
        $imgname = "";
        // 移动到框架应用根目录/static/uploads/banner/ 目录下
        if ($file)
        {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/news/');
            if ($info)
            {
                // 成功上传后 获取上传信息
                // 输出 jpg
                $imgname = $info->getSaveName();
                $imgUp=1;
            }
            else
            {
                // 上传失败获取错误信息
                return show(500,"图片上传失败，请重试",[],200);



            }
        }
        $data['ns_title']=addslashes($data['ns_title']);
        $data['ns_descript']=addslashes($data['ns_descript']);
        if($imgname)
        {
            $sql="update base_news set ns_title='".$data['ns_title']."',ns_img='".$imgname."',ns_descript='".$data['ns_descript']."',ns_content='".$data['editor1']."' where ns_id='".$data['id']."'";
        }
        else
        {
            $sql="update base_news set ns_title='".$data['ns_title']."',ns_descript='".$data['ns_descript']."',ns_content='".$data['editor1']."' where ns_id='".$data['id']."'";
        }
        Db::execute($sql);

        $tiaozhuanlujing="/admin/news/".$data['page'];
        return redirect($tiaozhuanlujing);
    }

    //新闻资讯封面提交处理
    public function post_newsCover_edit(){
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input('post.');//通过助手将POST所有数据交给 data
        // 获取表单上传文件 例如上传了001.jpg
        $imgUp=0;
        $file = request()->file('ns_img');
        $imgname = "";
        if ($file)
        {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/news/');
            if ($info)
            {
                // 成功上传后 获取上传信息
                // 输出 jpg
                $imgname = $info->getSaveName();
                $imgUp=1;
            }
            else
            {
                // 上传失败获取错误信息
                return show(500,"图片上传失败，请重试",[],200);
            }
        }
        if($imgname)
        {
            $sql="update base_news set ns_img='".$imgname."'";

        }
        Db::execute($sql);

        $tiaozhuanlujing="/admin/news/1";
        return redirect($tiaozhuanlujing);
    }
    //删除公司新闻 页面
    public function get_news_del()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');exit();
        }
        $data = input();//通过助手将POST所有数据交给 data

        $sql="delete from base_news where ns_id='".$data['id']."'";
        Db::query($sql);
        $tiaozhuanlujing="/admin/news/".$data['page'];
        return redirect($tiaozhuanlujing);
    }
}