<?php
namespace app\admin\validate;

use think\Validate;

class Index extends Validate
{
    protected $rule = [
      'dengluming' => 'require|chsAlphaNum|length:2,20',
      'mima' => 'alphaDash|length:2,20',
      'xingming' => 'require|chsAlpha|length:2,20',
//      'leixing' => 'require|number|length:1,1',
//      'zhuangtai' => 'require|number|length:1,1',
    ];

    protected $message  = [
          'dengluming.require' => '502',
          'dengluming.chsAlphaNum'  => '503',
          'dengluming.length' => '504',
          'mima.alphaDash'  => '506',
          'mima.length' => '507',
          'xingming.require' => '508',
          'xingming.chsAlpha' => '509',
          'xingming.length' => '510',
//          'leixing.require' => '511',
//          'leixing.number' => '512',
//          'leixing.length' => '513',
//          'zhuangtai.require' => '514',
//          'zhuangtai.number' => '515',
//          'zhuangtai.length' => '516',
    ];

    public function get_message($err_id)
    {
        $err_text = [
          '502' => '用户名不能为空',
          '503' => '用户名只能用汉字 字母 数字 可以混合',
          '504' => '用户名的长度 只能在2至7位之间',
          '506' => '密码只能用 字母 数字 _下划线 -破折号 可以混合',
          '507' => '密码的长度 只能在4至7位之间',
          '508' => '姓名不能为空',
          '509' => '姓名只能用汉字 字母 可以混合',
          '510' => '姓名的长度 只能在2至7位之间',
//          '511' => '类型不能为空',
//          '512' => '类型只能用数字',
//          '513' => '类型的长度 只能是1位',
//          '514' => '状态不能为空',
//          '515' => '状态只能用数字',
//          '516' => '状态的长度 只能是1位',
        ];
        return $err_text[$err_id];
    }
}
