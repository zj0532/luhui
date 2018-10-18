<?php
/**
 * Created by PhpStorm.
 * User: administarot
 * Date: 2018/9/2
 * Time: 9:43
 */

namespace app\admin\model;


use think\Model;

class AdminModel extends Model
{
    protected $table = 'base_admin';
    // 关闭自动写入时间戳
    protected $autoWriteTimestamp = false;
}