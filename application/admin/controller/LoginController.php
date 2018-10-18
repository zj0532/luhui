<?php
// 管理员后台 登陆模块
// User: tianyu
// Date: 18/3/23
// Time: 下午2:35
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\XitongjiluModel;
use app\admin\model\AdminModel;

class LoginController extends Controller
{
  //测试登陆
  public function get_login(){
    //初始为300
    return view('login',["haha" => "huhu123"]);
  }

  //测试登陆
  public function get_register(){
    //初始为300
    return view('register',["haha" => "huhu123"]);
  }

  //登陆
  public function post_login(){
      try{
          //初始为300
          $res = ["stat" => "300"];

          $data = input('post.');//通过助手将POST所有数据交给 data

          $validate = validate('Login');//实例化 验证器
          if (!$validate->check($data)) {
              $err_id = $validate->getError();
              return show($err_id, $validate->get_message($err_id), [], 200);
          }

          $admin = new AdminModel();
          $result = $admin->where('dengluming="'.$data['dengluming'].'" and mima="'.md5($data["mima"]).'"')->find();
          //$result = Db::query('SELECT * FROM base_admin WHERE dengluming=:dengluming and mima=md5(:mima) and zhuangtai=1', $data);
          //return $result;
          //$sql="select * from admin where dengluming='".input("ipt_user_id")."'";

          if($result)
          {
              session('admin_id',$result['adm_id']);
              session('admin_dengluming',$result['dengluming']);
              session('admin_xingming',$result['xingming']);
              session('session_start_time', time());//记录会话开始时间！判断会话时间的重点！重点！重点！

              //写入系统管理员操作日志表
              $request = Request::instance();
              $sql_xitongjilu='insert into base_xitongjilu (`gonghaoid`,`neirong`,`ip`,`Time`) VALUES ("'.session('admin_id').'","行为：登陆","'.$request->ip().'","'.time().'")';
              //echo $sql_xitongjilu;
              Db::execute($sql_xitongjilu);

              return show(200,"登陆成功",[],200);
          }
          else
          {
              return show(300,"登陆失败",[],200);
          }
      }catch (\Exception $e){
          return show('500',$e->getMessage(),'','200');
      }

  }

  //退出操作
  public function post_quit(){
	//写入系统管理员操作日志表
	$request = Request::instance();

    $XitongjiluModel = new XitongjiluModel();
      $XitongjiluModel->data([
            'gonghaoid' => session('admin_id'),
            'neirong' => "行为：退出登陆",
            'ip' => $request->ip(),
            'Time' => time()
      ]);
//	$sql_xitongjilu='insert into base_xitongjilu (`gonghaoid`,`neirong`,`ip`,`Time`) VALUES ("'.session('admin_id').'","行为：退出登陆","'.$request->ip().'","'.time().'")';
//	Db::execute($sql_xitongjilu);
      $XitongjiluModel->save();
	session(null);
//    $res = ["stat" => "200"];
//    return show(200, "退出成功", [], 200);
      $this->redirect('/admin/login');
  }
}
