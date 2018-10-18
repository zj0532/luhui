<?php
// 用户后台控制器
// User: tianyu
// Date: 18/3/28
// Time: 下午6:48
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\AdminModel;

class IndexController extends Controller
{

  //管理员列表页面
  public function get_index()
  {
	  //判断过期时间
	  $this->session_end();
      $j["sidebar"] = 1;
	  $sql="SELECT * FROM base_admin order by adm_id asc";
	  $j['list']=Db::query($sql);
      return view('index',$j);
  }
  //用户新增 页面
  public function get_index_add()
  {
	  //判断过期时间
	  $this->session_end();
	  //判断登陆状态
      if (!session('?admin_dengluming')) {
          return redirect('/admin/login');
      }
      $j["sidebar"] = 1;
      return view('index_add',$j);
  }
  //用户新增提交处理
  public function post_index_add()
  {
      try{
          //判断过期时间
          $this->session_end();
          //判断登陆状态
          if (!session('?admin_dengluming')) {
              return redirect('/admin/login');
          }
          $data = input('post.');//通过助手将POST所有数据交给 data


          $validate = validate('IndexController');//实例化 验证器
          if (!$validate->check($data)) {
              $err_id = $validate->getError();
              return show($err_id, $validate->get_message($err_id), [], 200);
          }


          //Db::execute('insert into think_user (id, name) values (:id, :name)',['id'=>8,'name'=>'thinkphp']);
//          $sql="insert into base_admin (dengluming,mima,xingming,leixing,zhuangtai) VALUES (:dengluming,md5(:mima),:xingming,:leixing,:zhuangtai)";
//          Db::execute($sql,$data);
          $admin = new AdminModel();
          $admin->data([
              'dengluming' => $data['dengluming'],
              'mima' => md5($data['mima']),
              'xingming' => $data['xingming'],
          ]);
          $admin->save();
          $j["sidebar"] = 1;
          $sql="SELECT * FROM base_admin order by adm_id asc";
          $j['list']=Db::query($sql);

//      return view('index',$j);
      }catch (\Exception $e){
          return show('500',$e->getMessage(),'','200');
      }

      return show('200','新增成功！','','200');
  }
  //用户编辑页面
  public function get_index_edit()
  {
	  //判断过期时间
	  $this->session_end();
	  //判断登陆状态
      if (!session('?admin_dengluming')) {
          return redirect('/admin/login');
      }
      $j["sidebar"] = 1;
	  $sql="SELECT * FROM base_admin where adm_id='".input('id')."'";
	  $result=Db::query($sql);
	  $j['userinfo']=$result[0];
      return view('index_edit',$j);
  }
  //用户编辑 提交 页面
  public function post_index_edit()
  {
      try{
          //判断过期时间
          $this->session_end();
          //判断登陆状态
          if (!session('?admin_dengluming')) {
              return redirect('/admin/login');
          }
          $data = input('post.');//通过助手将POST所有数据交给 data

          $validate = validate('Index');//实例化 验证器
          if (!$validate->check($data)) {
              $err_id = $validate->getError();
              return show($err_id, $validate->get_message($err_id), [], 200);
          }

          $admin = new AdminModel();
          //$sql="update admin set dengluming=:dengluming,mima=md5(:mima),xingming=:xingming,leixing=:leixing,zhuangtai=:zhuangtai where adm_id=:id";
          if($data['mima'])
          {
              $admin -> save([
                  'dengluming' => $data['dengluming'],
                  'mima' => md5($data['mima']),
                  'xingming' => $data['xingming'],
              ],['adm_id' => $data['id']]);
//              $sql="update base_admin set dengluming=:dengluming,mima=md5(:mima),xingming=:xingming,leixing=:leixing,zhuangtai=:zhuangtai where adm_id=:id";
//              Db::execute($sql,$data);
          }
          else
          {
              $admin -> save([
                  'dengluming' => $data['dengluming'],
                  'xingming' => $data['xingming'],
              ],['adm_id' => $data['id']]);
//              $sql="update base_admin set dengluming='".$data['dengluming']."',xingming='".$data['xingming']."',leixing='".$data['leixing']."',zhuangtai='".$data['zhuangtai']."' where adm_id='".$data['id']."'";
//              Db::execute($sql);
          }
          //echo $sql;
          $j["sidebar"] = 1;

//          $sql="SELECT * FROM base_admin order by adm_id asc";
          $j['list']=$admin->order('adm_id','asc')->select();
      }catch (\Exception $e){
          $this->error($e->getMessage());
      }
//      return view('index',$j);
       return show('200','管理员编辑成功！','','200');
  }

  //系统操作日志页面
  public function get_xitongrizhi()
  {
	  //判断过期时间
	  $this->session_end();
	  //判断登陆状态
      if (!session('?admin_dengluming')) {
          return redirect('/admin/login');
      }
      $j["sidebar"] = 5;

	  $data = input();//通过助手将POST所有数据交给 data

	  $data['page']=intval($data['page'])?intval($data['page']):1;
	  $data['guanliyuanid']=intval($data['guanliyuanid'])?intval($data['guanliyuanid']):"0";
	  $data['kaishishijian']=$data['kaishishijian']?$data['kaishishijian']:"0";
	  $data['jiesushijian']=$data['jiesushijian']?$data['jiesushijian']:"0";


	  $pagesize=30;
	  $page=$data['page'];
	  $start=($page-1)*$pagesize;
      $step=$pagesize;

	  $sqlstr="";
	  $sqlstrarray=array();
	  if($data['guanliyuanid'])
	  {

		 $sqlstrarray[]=" zd.gonghaoid='".$data['guanliyuanid']."'";
	  }
 	  if($data['kaishishijian'] && $data['jiesushijian'])
	  {
		 $sqlstrarray[]=" zd.Time>='".strtotime($data['kaishishijian']." 00:00:00")."' and  zd.Time<='".strtotime($data['jiesushijian']." 23:59:59")."'";
	  }
	  if($data['kaishishijian'] && !$data['jiesushijian'])
	  {
		 $sqlstrarray[]=" zd.Time>='".strtotime($data['kaishishijian']." 00:00:00")."'";
	  }
	  if(!$data['kaishishijian'] && $data['jiesushijian'])
	  {
		 $sqlstrarray[]=" zd.Time<='".strtotime($data['jiesushijian']." 23:59:59")."'";
	  }

	  $sqlstr=implode(" and ",$sqlstrarray);
	  //echo $sqlstr;
	  if($sqlstr)
	  {
		 $sqlstr=" and ".$sqlstr;
	  }

	  $sqlnum = "select count(*) num from base_xitongjilu as zd,base_admin as sh  where zd.gonghaoid=sh.adm_id ".$sqlstr;
	  $resultnum=Db::query($sqlnum);
	  $j["countnum"] = $resultnum[0]['num'];

	  $pagenumber=floor($resultnum[0]['num']/$pagesize)+1;

	  $data['shangpage']=intval($data['page'])>1?intval($data['page'])-1:1;
	  $data['xiapage']=intval($data['page'])<$pagenumber?intval($data['page'])+1:intval($data['page']);
	  $data['countpage']=$pagenumber;

	  $j["data"] = $data;

	  $sql="select * from base_xitongjilu as zd,base_admin as sh  where zd.gonghaoid=sh.adm_id ".$sqlstr." order by zd.xtjl_id desc limit " . $start . ", " . $step;
	  // echo $sql;
	  $result=Db::query($sql);
	  $j["info"] = $result;
	 // print_r($j);
      return view('xitongrizhi',$j);
  }



}
