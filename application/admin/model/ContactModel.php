<?php
/**
 * Created by PhpStorm.
 * User: administarot
 * Date: 2018/9/1
 * Time: 9:55
 */

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class ContactModel extends Model{
    use SoftDelete;
    // 定义时间戳字段名
    protected $createTime = 'cu_create_time';
    protected $updateTime = 'cu_update_time';
    // 定义软删除字段名
    protected $deleteTime = 'cu_delete_time';
    // 设置当前模型对应的完整数据表名称
    protected $table = 'base_contact';
}