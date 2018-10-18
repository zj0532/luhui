<?php
/**
 * Created by PhpStorm.
 * User: administarot
 * Date: 2018/9/1
 * Time: 16:51
 */

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class BannerModel extends Model
{
    use SoftDelete;
    // 定义时间戳字段名
    protected $createTime = 'bn_create_time';
    protected $updateTime = 'bn_update_time';
    // 定义软删除字段名
    protected $deleteTime = 'bn_delete_time';
    // 设置当前模型对应的完整数据表名称
    protected $table = 'base_banner';
}