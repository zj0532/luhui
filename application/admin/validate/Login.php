<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
      'dengluming' => 'require|chsAlphaNum|length:2,20',
      'mima' => 'require|alphaDash|length:2,20',
    ];

    protected $message  = [
          'dengluming.require' => '502',
          'dengluming.chsAlphaNum'  => '503',
          'dengluming.length' => '504',
          'mima.require' => '505',
          'mima.alphaDash'  => '506',
          'mima.length' => '507',
    ];

    public function get_message($err_id)
    {
        $err_text = [
          '502' => '用户名不能为空',
          '503' => '用户名只能用汉字 字母 数字 可以混合',
          '504' => '用户名的长度 只能在4至7位之间',
          '505' => '密码不能为空',
          '506' => '密码只能用 字母 数字 _下划线 -破折号 可以混合',
          '507' => '密码的长度 只能在4至7位之间',
        ];
        return $err_text[$err_id];
    }
}
