<?php
/**
 * Created by PhpStorm.
 * User: administarot
 * Date: 2018/9/2
 * Time: 15:08
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use app\admin\model\ProductModel;

class ProductController extends Controller
{
    //产品展示列表
    public function get_product_list()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }

        $j["sidebar"] = 2;
        $data=input();
        $data['page']=intval($data['page'])?intval($data['page']):1;
        $pagesize=10;
        $page=$data['page'];
        $start=($page-1)*$pagesize;
        $step=$pagesize;
        $product = new ProductModel();

//        $sqlnum = "select count(*) num from base_product  ";
//        $resultnum=Db::query($sqlnum);
        $resultnum =  $product->count();
        //总记录数
        $data["countnum"] = $resultnum;
        //总页数
        $pagenumber=floor($resultnum/$pagesize)+1;
        $data['countpage']=$pagenumber;
        //上一页
        $data['shangpage']=intval($page)>1?intval($page)-1:1;
        //下一页
        $data['xiapage']=intval($page)<$pagenumber?intval($page)+1:intval($page);

        $j["data"] = $data;

        $sql="SELECT * FROM base_product order by pd_id desc limit " . $start . ", " . $step;
        $j['list']=Db::query($sql);
        $j['imgpath']=config("product_upload_path");
        return view('product',$j);
    }

    //新增产品展示 页面
    public function get_product_add()
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
        return view('product_add',$j);
    }
    //新增产品展示 提交处理
    public function post_product_add()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }

        $data = input('post.');//通过助手将POST所有数据交给 data
        //print_r($data);
        $files = input('FILES');//通过助手将POST所有数据交给 data
        //print_r($_FILES);


        // 获取表单上传文件 例如上传了001.jpg
        $imgUp=0;
        $file = request()->file('pd_img');
        $imgname = "";
        // 移动到框架应用根目录/static/uploads/gonggao/ 目录下
        if ($file)
        {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/product/');
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
        $data['pd_title']=addslashes($data['pd_title']);
        $data['pd_content']=addslashes($data['pd_content']);
        if($imgname)
        {
            $sql="insert into base_product (pd_img,pd_title,pd_content,pd_order,pd_intime) VALUES
		  ('".$imgname."',
		  '".$data['pd_title']."',
		  '".$data['pd_content']."',
		  '".$data['pd_order']."',
		  '".time()."')";
        }
        else
        {
            $sql="insert into base_product (pd_title,pd_content,pd_order,pd_intime) VALUES
		  ('".$data['pd_title']."','".$data['pd_content']."','".$data['pd_order']."','".time()."')";
        }
        if(Db::execute($sql)){
            $this->success('添加产品展示成功！','/admin/product/1');
        }else{
            $this->error('添加产品展示失败！');
        }

//        $tiaozhuanlujing="/admin/product/1";
//        return redirect($tiaozhuanlujing);
    }

    //编辑产品展示 页面
    public function get_product_edit()
    {
        //判断过期时间
        $this->session_end();
        //判断登陆状态
        if (!session('?admin_dengluming')) {
            return redirect('/admin/login');
        }
        $data = input();//通过助手将POST所有数据交给 data

        $sql="select * from base_product where pd_id='".$data['id']."'";
        $aa=Db::query($sql);
        $j['list']=$aa[0];
        $j['id']=$data['id'];
        $j['page']=$data['page'];
        $j['imgpath']=config("product_upload_path");
        $j["sidebar"] = 15;
        return view('product_edit',$j);
    }
    //编辑产品展示 提交处理
    public function post_product_edit()
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
        $file = request()->file('pd_img');
        $imgname = "";
        // 移动到框架应用根目录/static/uploads/banner/ 目录下
        if ($file)
        {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/static/uploads/product/');
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
        $data['pd_title']=addslashes($data['pd_title']);
        $data['pd_content']=addslashes($data['pd_content']);
        $data['pd_order']=addslashes($data['pd_order']);
        if($imgname)
        {
            $sql="update base_product set pd_title='".$data['pd_title']."',
            pd_img='".$imgname."',
            pd_content='".$data['pd_content']."',
            pd_order='".$data['pd_order']."' where pd_id='".$data['id']."'";
        }
        else
        {
            $sql="update base_product set pd_title='".$data['pd_title']."',
            pd_content='".$data['pd_content']."',
            pd_order='".$data['pd_order']."' where pd_id='".$data['id']."'";
        }
        if(Db::execute($sql)){
            $this->success('产品展示编辑成功！','/admin/product/'.$data['page']);
        }else{
            $this->error('产品展示编辑失败！');
        }

//        $tiaozhuanlujing="/admin/product/".$data['page'];
//        return redirect($tiaozhuanlujing);
    }

    //删除产品展示 页面
    public function get_product_del()
    {
        try{
            //判断过期时间
            $this->session_end();
            //判断登陆状态
            if (!session('?admin_dengluming')) {
                return redirect('/admin/login');
            }
            $data = input();//通过助手将POST所有数据交给 data

            $sql="delete from base_product where pd_id='".$data['id']."'";
            Db::query($sql);



//        $tiaozhuanlujing="/admin/product/".$data['page'];
//        return redirect($tiaozhuanlujing);
        }catch (\Exception $e){
             $this->error('产品展示删除失败！');
        }
        $this->success('产品展示删除成功！','/admin/product/'.$data['page']);
    }
}