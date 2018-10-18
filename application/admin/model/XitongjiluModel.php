<?php
/**
 * Created by PhpStorm.
 * User: administarot
 * Date: 2018/9/1
 * Time: 20:54
 */

namespace app\admin\model;


use think\Model;

class XitongjiluModel extends Model
{
    protected $table = 'base_xitongjilu';
    // 关闭自动写入时间戳
    protected $autoWriteTimestamp = false;
}