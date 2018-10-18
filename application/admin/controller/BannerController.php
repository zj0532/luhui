<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3 0003
 * Time: 16:56
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

class BannerController extends Controller
{
    //banner列表
    public function get_banner_list()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }

        $j["sidebar"] = 6;
        $data=input();
        $data['page']=intval($data['page'])?intval($data['page']):1;
        $pagesize=30;
        $page=$data['page'];
        $start=($page-1)*$pagesize;
        $step=$pagesize;

        $sqlnum = "select count(*) num from base_banner  ";
        $resultnum=Db::query($sqlnum);
        //print_r($resultnum); exit();
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
        //print_r($j); exit();


        $sql="SELECT * FROM base_banner order by bn_id desc limit " . $start . ", " . $step;
        $j['list']=Db::query($sql);
        $j['imgpath']=config("banner_upload_path");
        //return print_r(session(''));
        //print_r($j);exit();
        return view('banner',$j);
    }

    //新增banner 页面
    public function get_banner_add()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data
        $j["sidebar"] = 6;
        return view('banner_add',$j);
    }
    //新增banner 提交处理
    public function post_banner_add()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');
            }
            $data = input('post.');//通过助手将POST所有数据交给 data

            $data['bn_title']=addslashes($data['bn_title']);
            $data['bn_content']=addslashes($data['bn_content']);
            $data['bn_url']=addslashes($data['bn_url']);

            // 获取表单上传文件 例如上传了001.jpg
            $imgUp=0;
            $file = request()->file('bn_img');
            $imgname = "";
            // 移动到框架应用根目录/static/uploads/banner/ 目录下
            if ($file)
            {
                $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/banner/');
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
                $sql="insert into base_banner (bn_title,bn_content,bn_img,bn_order,bn_url) VALUES
		  ( '".$data['bn_title']."',
		   '".$data['bn_content']."',
		   '".$imgname."',
		   '".$data['bn_order']."',
		   '".$data['bn_url']."')";
            }
            else
            {
                $sql="insert into base_banner (bn_title,bn_content, bn_order,bn_url) VALUES
		  ('".$data['bn_title']."',
		  '".$data['bn_content']."',
		  '".$data['bn_order']."',
		  '".$data['bn_url']."')";
            }
            Db::execute($sql);

        }catch (\Exception $e){
            $this->error('添加BANNER失败,请联系管理员！');
        }
        $this->success('添加BANNER成功！','/admin/banner/1');
    }

    //编辑 banner 页面
    public function get_banner_edit()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data

        $sql="select * from base_banner where bn_id='".$data['id']."'";
        $aa=Db::query($sql);
        $j['list']=$aa[0];
        $j['id']=$data['id'];
        $j['page']=$data['page'];
        $j['imgpath']=config("banner_upload_path");
        $j["sidebar"] = 13;
        //print_r($j);exit();
        return view('banner_edit',$j);
    }
    //编辑banner 提交处理
    public function post_banner_edit()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');
            }
            $data = input('post.');//通过助手将POST所有数据交给 data

            $data['bn_title']=addslashes($data['bn_title']);
            $data['bn_content']=addslashes($data['bn_content']);
            $data['bn_url']=addslashes($data['bn_url']);

            // 获取表单上传文件 例如上传了001.jpg
            $imgUp=0;
            $file = request()->file('bn_img');
            $imgname = "";
            // 移动到框架应用根目录/static/uploads/banner/ 目录下
            if ($file)
            {
                $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/banner/');
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
                $sql="update base_banner set 
	          bn_title='".$data['bn_title']."',
              bn_content='".$data['bn_content']."',
              bn_img='".$imgname."',
              bn_order='".$data['bn_order']."',
              bn_url='".$data['bn_url']."'
                 where bn_id='".$data['id']."'";
            }
            else
            {
                $sql="update base_banner set 
              bn_title='".$data['bn_title']."',
              bn_content='".$data['bn_content']."',
              bn_order='".$data['bn_order']."',
              bn_url='".$data['bn_url']."'
              where bn_id='".$data['id']."'";
            }
            Db::execute($sql);

        }catch (\Exception $e){
            $this->error('编辑BANNER失败,请联系管理员！');
        }
        $this->success('添加BANNER成功！','/admin/banner/'.$data['page']);
    }

    //删除 banner 页面
    public function get_banner_del()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');exit();
            }
            $data = input();//通过助手将POST所有数据交给 data

            $sql="delete from base_banner where bn_id='".$data['id']."'";
            Db::query($sql);
        }catch (\Exception $e){
            $this->error('删除BANNER失败,请联系管理员！');
        }
        $this->success('删除BANNER成功','/admin/banner/'.$data['page']);
    }
}