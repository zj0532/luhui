<?php
use think\Route;
Route::get('/admin/','admin/index/get_index');//管理员首页
Route::get('/admin/login','admin/login/get_login');//登陆页面
 
Route::post('/admin/login','admin/login/post_login');//登陆逻辑
Route::post('/admin/quit','admin/login/post_quit');//退出逻辑

//管理员
Route::get('admin/indexAdd','admin/index/get_index_add');
Route::post('admin/indexAdd','admin/index/post_index_add');
Route::get('admin/indexEdit/:id','admin/index/get_index_edit');
Route::post('admin/indexEdit/:id','admin/index/post_index_edit');


//banner
Route::get('admin/banner/:page','admin/banner/get_banner_list');
Route::get('admin/bannerAdd','admin/banner/get_banner_add');
Route::post('admin/bannerAdd','admin/banner/post_banner_add');
Route::get('admin/bannerEdit/:id/:page','admin/banner/get_banner_edit');
Route::post('admin/bannerEdit/:id/:page','admin/banner/post_banner_edit');
Route::get('admin/bannerDel/:id/:page','admin/banner/get_banner_del');

//新闻资讯
Route::get('admin/news/:page','admin/news/get_news_list');
Route::get('admin/newsAdd','admin/news/get_news_add');
Route::post('admin/newsAdd','admin/news/post_news_add');
Route::get('admin/newsEdit/:id/:page','admin/news/get_news_edit');
Route::post('admin/newsEdit/:id/:page','admin/news/post_news_edit');
Route::get('admin/newsDel/:id/:page','admin/news/get_news_del');
Route::post('admin/newsCover/','admin/news/post_newsCover_edit'); //新闻资讯封面

//公告
Route::get('admin/gonggao/:page','admin/index/get_gonggao_list');
Route::get('admin/gonggaoAdd','admin/index/get_gonggao_add');
Route::post('admin/gonggaoAdd','admin/index/post_gonggao_add');
Route::get('admin/gonggaoEdit/:id/:page','admin/index/get_gonggao_edit');
Route::post('admin/gonggaoEdit/:id/:page','admin/index/post_gonggao_edit');
Route::get('admin/gonggaoDel/:id/:page','admin/index/get_gonggao_del');

//产品展示
Route::get('admin/product/:page','admin/product/get_product_list');
Route::get('admin/productAdd','admin/product/get_product_add');
Route::post('admin/productAdd','admin/product/post_product_add');
Route::get('admin/productEdit/:id/:page','admin/product/get_product_edit');
Route::post('admin/productEdit/:id/:page','admin/product/post_product_edit');
Route::get('admin/productDel/:id/:page','admin/product/get_product_del');

//生产环境
Route::get('admin/production/:page','admin/production/get_production_list');
Route::get('admin/productionAdd','admin/production/get_production_add');
Route::post('admin/productionAdd','admin/production/post_production_add');
Route::get('admin/productionEdit/:id/:page','admin/production/get_production_edit');
Route::post('admin/productionEdit/:id/:page','admin/production/post_production_edit');
Route::get('admin/productionDel/:id/:page','admin/production/get_production_del');

//联系我们
Route::get('admin/contactEdit','admin/contact/get_contact_edit');
Route::post('admin/contactEdit','admin/contact/post_contact_edit');
?>
