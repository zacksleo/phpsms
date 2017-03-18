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
    public function sendSms($to, $content, $tempId, array $tempData)
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
        $result = $this->curl($sendUrl, $params, true);
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
