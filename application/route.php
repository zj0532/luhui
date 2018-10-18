<?php
// 路由入口
// User: tianyu
// Date: 18/3/28
// Time: 下午5:18
// Mark: 引入了网站 商户后台 系统后台 3个路由文件
use think\Route;
include_once('route/www_route.php');//支付网站页面路由
include_once('route/admin_route.php');//系统后台路由
Route::miss('index/index/miss');
?>
