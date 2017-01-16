# phpsms
互亿无线短信接口, 基于phpsms

## 详细文档见 [文档](https://github.com/toplan/phpsms)

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

