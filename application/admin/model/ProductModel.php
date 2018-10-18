<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3 0003
 * Time: 15:28
 */

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class ProductModel extends Model
{
    use SoftDelete;
    // 定义时间戳字段名
    protected $createTime = 'pd_create_time';
    protected $updateTime = 'pd_update_time';
    // 定义软删除字段名
    protected $deleteTime = 'pd_delete_time';
    // 设置当前模型对应的完整数据表名称
    protected $table = 'base_product';
}