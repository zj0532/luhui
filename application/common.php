<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
// 公共返回函数
function show($status, $message, $data=[], $httpCode=200) {

    $datas = [
        'status' => $status,//状态码
        'message' => $message,//状态信息
        'data' => $data,//数据
    ];

    return json($datas, $httpCode);
}


function user_log($message) {
  $sql =  "INSERT INTO shanghujilu VALUES(NULL,:shanghu,:message,:ip,:time)";
  $result = Db::execute($sql,["shanghu" => session("user_id"),
                            "message" => $message,
                            "ip" => request()->ip(),
                            "time" => time()]);
}