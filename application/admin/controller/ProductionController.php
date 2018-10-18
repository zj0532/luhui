<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3 0003
 * Time: 16:12
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

class ProductionController extends Controller
{
    //生产环境列表
    public function get_production_list()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }

        $j["sidebar"] = 3;
        $data=input();
        $data['page']=intval($data['page'])?intval($data['page']):1;
        $pagesize=10;
        $page=$data['page'];
        $start=($page-1)*$pagesize;
        $step=$pagesize;

        $sqlnum = "select count(*) num from base_production  ";
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

        $sql="SELECT * FROM base_production order by pe_id desc limit " . $start . ", " . $step;
        $j['list']=Db::query($sql);
        $j['imgpath']=config("production_upload_path");
        return view('production',$j);
    }

    //新增生产环境 页面
    public function get_production_add()
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
        return view('production_add',$j);
    }
    //新增生产环境 提交处理
    public function post_production_add()
    {
        try{
//判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');
            }

            $data = input('post.');//通过助手将POST所有数据交给 data
            $files = input('FILES');//通过助手将POST所有数据交给 data

            // 获取表单上传文件 例如上传了001.jpg
            $imgUp=0;
            $file = request()->file('pe_img');
            $imgname = "";
            // 移动到框架应用根目录/static/uploads/gonggao/ 目录下
            if ($file)
            {
                $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/production/');
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


            $data['pe_title']=addslashes($data['pe_title']);
            if($imgname)
            {
                $sql="insert into base_production (pe_title,pe_img,pe_order) VALUES
		  ( '".$data['pe_title']."',
		  '".$imgname."',
		  '".$data['pe_order']."')";
            }
            else
            {
                $sql="insert into base_production (pe_title,pe_order) VALUES
		  ('".$data['pe_title']."',
		  '".$data['pe_order']."')";
            }
            Db::execute($sql);

//            $tiaozhuanlujing="/admin/production/1";
//            return redirect($tiaozhuanlujing);
        }catch (\Exception $e){
            $this->error('添加生产环境失败,请联系管理员！');
        }
        $this->success('添加生产环境成功！','/admin/production/1');
    }

    //编辑生产环境 页面
    public function get_production_edit()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data

        $sql="select * from base_production where pe_id='".$data['id']."'";
        $result=Db::query($sql);
        $j['id']=$data['id'];
        $j['page']=$data['page'];
        $j['imgpath']=config("production_upload_path");
        $j["sidebar"] = 15;
        $this->assign('result',$result);
        return view('production_edit',$j);
    }
    //编辑生产环境 提交处理
    public function post_production_edit()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');
            }
            $data = input('post.');//通过助手将POST所有数据交给 data

            // 获取表单上传文件 例如上传了001.jpg
            $imgUp=0;
            $file = request()->file('pe_img');
            $imgname = "";
            // 移动到框架应用根目录/static/uploads/banner/ 目录下
            if ($file)
            {
                $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/production/');
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
            $data['pe_title']=addslashes($data['pe_title']);
            if($imgname)
            {
                $sql="update base_production set pe_title='".$data['pe_title']."',
            pe_img='".$imgname."',
            pe_order='".$data['pe_order']."' where pe_id='".$data['id']."'";
            }
            else
            {
                $sql="update base_production set pe_title='".$data['pe_title']."',
            pe_order='".$data['pe_order']."' where pe_id='".$data['id']."'";
            }
            Db::execute($sql);

//            $tiaozhuanlujing="/admin/production/".$data['page'];
//            return redirect($tiaozhuanlujing);
        }catch (\Exception $e){
            $this->error('编辑生产环境失败,请联系管理员！');
        }
        $this->success('编辑生产环境成功！','/admin/production/'.$data['page']);
    }

    //删除生产环境 页面
    public function get_production_del()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');exit();
            }
            $data = input();//通过助手将POST所有数据交给 data

            $sql="delete from base_production where pe_id='".$data['id']."'";
            Db::query($sql);
//            $tiaozhuanlujing="/admin/production/".$data['page'];
//            return redirect($tiaozhuanlujing);
        }catch (\Exception $e){
            $this->error('删除生产环境失败,请联系管理员！');
        }
        $this->success('删除生产环境成功！','/admin/production/1');
    }
}