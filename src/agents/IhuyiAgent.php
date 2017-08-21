<?php

namespace zacksleo\PhpSms;

use Toplan\PhpSms\Agent;

/**
 * Class 互亿无线短信接口
 * @package Toplan\PhpSms
 * @property string $sendUrl
 * @property string $apiKey
 * @property string $secretKey
 * @property string $smsFreeSignName
 * @property string $calledShowNum
 */
class IhuyiAgent extends Agent
{
    public function sendSms($to, $content = null, $tempId = null, array $tempData = [], array $params = [])
    {
        $this->sendContentSms($to, $content);
    }

    public function voiceVerify($to, $code, $tempId, array $tempData)
    {
    }

    public function sendTemplateSms($to, $tempId, array $tempData)
    {
    }

    public function sendContentSms($to, $content)
    {
        $to = ltrim($to, '+');
        //如果是中国的手机号，去掉86，并使用国内短信网关
        if (preg_match('/^86\s[1][34578][0-9]{9}$/', $to)) {
            $to = substr($to, -11, 11);
        } elseif (preg_match('/^[1][34578][0-9]{9}$/', $to)) {
            $this->sendUrl = 'http://106.ihuyi.cn/webservice/sms.php?method=Submit';
        } else {
            $this->sendUrl = 'http://api.isms.ihuyi.com/webservice/isms.php?method=Submit';
        }
        $params = [
            'mobile' => $to,
            'content' => $content,
        ];
        $this->request($params);
    }

    protected function request(array $params)
    {
        $sendUrl = $this->sendUrl ?: 'http://106.ihuyi.cn/webservice/sms.php?method=Submit';
        $params = $this->createParams($params);
        $result = $this->curlPost($sendUrl, $params);
        $this->setResult($result);
    }

    protected function createParams(array $params)
    {
        $params = array_merge([
            'account' => $this->apiKey,
            'password' => $this->secretKey,
        ], $params);
        return $params;
    }

    protected function setResult($result)
    {
        if (!$result['request']) {
            $this->result(Agent::SUCCESS, false);
        } else {
            $return = @simplexml_load_string($result['response']);
            $this->result(Agent::SUCCESS, $return->code == 2);
            $this->result(Agent::CODE, $return->code);
            $this->result(Agent::INFO, $return->msg);
        }
    }
}
