<?php
namespace app\admin\validate;

use think\Validate;

class Authen extends Validate
{

    protected $rule = [
      'shanghuming' => 'require|chsAlpha|length:3,16',
      'shenhe_shenfenzheng_hao' => 'require|alphaNum|length:18',
      'shenhe_shoujihao' => 'require|number|length:11',
      'shoukuan_ren' => 'require|chs|length:3,15',
      'shoukuan_zhanghu' => 'require|number|length:4,21',
      'shoukuan_qudao' => 'require|number',
      'shoukuan_beizhu' => 'require|chsAlphaNum|length:0,83',
      'shanghu_huitiao' => 'require|url|length:4,50',
      'bai_ip' => 'require|ip'
    ];

    protected $message  = [
          'shanghuming.require' => '502',
          'shanghuming.chsAlpha'  => '503',
          'shanghuming.length' => '504',
          'shenhe_shenfenzheng_hao.require' => '505',
          'shenhe_shenfenzheng_hao.alphaNum'  => '506',
          'shenhe_shenfenzheng_hao.length' => '507',
          'shenhe_shoujihao.require' => '517',
          'shenhe_shoujihao.number'  => '518',
          'shenhe_shoujihao.length' => '519',
          'shoukuan_ren.require' => '520',
          'shoukuan_ren.chs'  => '521',
          'shoukuan_ren.length' => '522',
          'shoukuan_zhanghu.require' => '523',
          'shoukuan_zhanghu.number'  => '524',
          'shoukuan_zhanghu.length' => '525',
          'shoukuan_qudao.require' => '526',
          'shoukuan_qudao.number'  => '527',
          'shoukuan_beizhu.require' => '528',
          'shoukuan_beizhu.chsAlphaNum'  => '529',
          'shoukuan_beizhu.length'  => '530',
          'shanghu_huitiao.require' => '531',
          'shanghu_huitiao.url'  => '532',
          'shanghu_huitiao.length'  => '533',
          'bai_ip.require' => '534',
          'bai_ip.ip'  => '535',
          'bai_ip.length'  => '536',
    ];

    public function get_message($err_id)
    {
        $err_text = [
          '502' => '商户名不能为空',
          '503' => '商户名只能用汉字 字母可以混合',
          '504' => '商户名的长度 只能在3至16位之间',
          '505' => '法人身份证号 不能为空',
          '506' => '法人身份证号 格式错误',
          '507' => '法人身份证号 只能为18位',
          '508' => '身份证正面图片 不能为空',
          '509' => '身份证正面图片 格式错误',
          '510' => '身份证正面图片 格式错误',
          '511' => '身份证背面图片 不能为空',
          '512' => '身份证背面图片 格式错误',
          '513' => '身份证背面图片 格式错误',
          '514' => '营业执照图片 不能为空',
          '515' => '营业执照图片 格式错误',
          '516' => '营业执照图片 格式错误',
          '517' => '手机号 不能为空',
          '518' => '手机号 格式错误',
          '519' => '手机号 格式错误',
          '520' => '结算账户名 不能为空',
          '521' => '结算账户名 只能为汉字',
          '522' => '结算账户名 格式错误',
          '523' => '结算账户号 不能为空',
          '524' => '结算账户号 只能为数字',
          '525' => '结算账户号 格式错误',
          '526' => '结算银行 不能为空',
          '527' => '结算银行 格式错误',
          '528' => '结算备注 不能为空',
          '529' => '结算备注 格式错误',
          '530' => '结算备注 格式错误',
          '531' => '支付结果通知地址 不能为空',
          '532' => '支付结果通知地址 格式错误',
          '533' => '支付结果通知地址 格式错误',
          '534' => '商户服务器ip 不能为空',
          '535' => '商户服务器ip 格式错误',
          '536' => '商户服务器ip 格式错误',
        ];
        return $err_text[$err_id];
    }
}
