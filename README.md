# phpsms

[![Latest Stable Version](https://poser.pugx.org/zacksleo/phpsms/version)](https://packagist.org/packages/zacksleo/phpsms)
[![Total Downloads](https://poser.pugx.org/zacksleo/phpsms/downloads)](https://packagist.org/packages/zacksleo/phpsms)
[![License](https://poser.pugx.org/zacksleo/phpsms/license)](https://packagist.org/packages/zacksleo/phpsms)

互亿无线短信接口, 基于phpsms

## 详细文档见 [PhpSms文档](https://github.com/toplan/phpsms/blob/master/README.md)

## 用法示例
```
Sms::scheme('Ihuyi', [
    '100 backup',
    'agentClass' => 'zacksleo\PhpSms\IhuyiAgent'
]);        

Sms::config([
    'Ihuyi' => [
        'apiKey' => 'apikey',
        'secretKey' => 'secretkey'
    ]
]);
     

$res = Sms::make()->to('手机号码')->content('短信内容')->send(false);
     
```

