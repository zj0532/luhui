<?php
use think\Route;

Route::get('/','index/index/index');//首页
//新闻资讯
Route::get('/news_list/','index/index/news_list');// 文章list
Route::get('/news/:page','index/index/news');// 文章

Route::post('/admin','admin/index/get_index');//管理员首页
Route::get('/admin/quit','admin/login/post_quit');//退出逻辑
?>
