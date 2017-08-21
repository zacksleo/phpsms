# phpsms

[![Latest Stable Version](https://poser.pugx.org/zacksleo/phpsms/version)](https://packagist.org/packages/zacksleo/phpsms)
[![Total Downloads](https://poser.pugx.org/zacksleo/phpsms/downloads)](https://packagist.org/packages/zacksleo/phpsms)
[![License](https://poser.pugx.org/zacksleo/phpsms/license)](https://packagist.org/packages/zacksleo/phpsms)
[![styleci](https://styleci.io/repos/98153638/shield)](https://styleci.io/repos/98153638)
[![Build Status](https://travis-ci.org/Graychen/phpsms.svg?branch=master)](https://travis-ci.org/Graychen/phpsms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Graychen/phpsms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Graychen/phpsms/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Graychen/phpsms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Graychen/phpsms/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Graychen/phpsms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Graychen/phpsms/build-status/master)

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

