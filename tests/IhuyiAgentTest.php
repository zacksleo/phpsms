<?php
namespace zacksleo\PhpSms\tests;

use Toplan\PhpSms\Agent;
use zacksleo\PhpSms\IhuyiAgent;
use Toplan\PhpSms\Sms;

/**
 *
 */
class IhuyiAgentTest extends \PHPUnit_Framework_TestCase
{
    protected static $sms=null;


    public static function setUpBeforeClass()
    {
        Sms::cleanScheme();
        Sms::scheme('Ihuyi', [
              '100 backup',
              'agentClass' => 'zacksleo\PhpSms\IhuyiAgent'
          ]);
        self::$sms=Sms::make();
    }

    public function testMakeSms()
    {
        $this->assertInstanceOf('Toplan\PhpSms\Sms', self::$sms);
    }

    public function testHasAgent()
    {
        $this->assertFalse(Sms::hasAgent('Ihuyi'));
        $this->assertFalse(Sms::hasAgent('SomeAgent'));

        Sms::getAgent('Ihuyi');
        $this->assertTrue(Sms::hasAgent('Ihuyi'));
    }

    public function testGetAgent()
    {
        $agent = Sms::getAgent('Ihuyi');
        $this->assertInstanceOf('Toplan\PhpSms\Agent', $agent);
    }

    public function testGetTask()
    {
        $task = Sms::getTask();
        $this->assertInstanceOf('Toplan\TaskBalance\Task', $task);
    }

    public function testGetSmsData()
    {
        $data = self::$sms->all();
        $this->assertArrayHasKey('to', $data);
        $this->assertArrayHasKey('templates', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('content', $data);
        $this->assertArrayHasKey('code', $data);
        $this->assertArrayHasKey('files', $data);
        $this->assertArrayHasKey('params', $data);
        self::$sms->to('...');
        $this->assertEquals('...', self::$sms->all('to'));
    }

    public function testSetTo()
    {
        self::$sms->to('18280345...');
        $this->assertEquals('18280345...', self::$sms->all('to'));
    }

    public function testSetTemplate()
    {
        self::$sms->template('Luosimao', '123');
        $smsData = self::$sms->all();
        $this->assertEquals([
        'Luosimao' => '123',
        ], $smsData['templates']);
        self::$sms->template([
            'Luosimao' => '1234',
            'YunTongXun' => '6789',
        ]);
        $smsData = self::$sms->all();
        $this->assertEquals([
            'Luosimao' => '1234',
            'YunTongXun' => '6789',
        ], $smsData['templates']);
    }

    public function testSetData()
    {
        self::$sms->data([
            'code' => '1',
            'msg' => 'msg',
        ]);
        $smsData = self::$sms->all();
        $this->assertEquals([
            'code' => '1',
            'msg' => 'msg',
        ], $smsData['data']);
    }

    public function testSetContent()
    {
        self::$sms->content('this is content');
        $smsData = self::$sms->all();
        $this->assertEquals('this is content', $smsData['content']);
    }

    public function testSendSms()
    {
        $result = self::$sms->send();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('time', $result);
        $this->assertArrayHasKey('logs', $result);
    }

    public function testBeforeSend()
    {
        Sms::beforeSend(function () {
            print_r('before_');
        });
        $this->expectOutputString('before_');
        self::$sms->send();
    }

    public function testAfterSend()
    {
        self::$sms->afterSend(function () {
            print_r('after');
        });
        $this->expectOutputString('before_after');
        self::$sms->send();
    }

    public function testSetAgent()
    {
        $result = self::$sms->agent('Ihuyi')->send();
        $this->assertFalse($result['success']);
     //   $this->assertCount(1, $result['Ihuyi']);
     //   $this->assertEquals('Ihuyi', $result['logs'][0]['driver']);
    }

    public function testVoice()
    {
        $sms = Sms::voice('code');
        $data = $sms->all();
        $this->assertEquals('code', $data['code']);
    }

    public function testUseQueue()
    {
        $status = Sms::queue();
        $this->assertFalse($status);

        Sms::queue(false, function ($sms, $data) {
            return 'in_queue_2';
        });
        $this->assertFalse(Sms::queue());

        Sms::queue(true);
        $this->assertTrue(Sms::queue());

        $result = self::$sms->send();
        $this->assertEquals('in_queue_2', $result);

        $result = self::$sms->send(true);
        $this->assertFalse($result['success']);
      //  $this->assertContent(1,$result['Ihuyi']);
      //  $this->assertEquals('Ihuyi',$result['Ihuyi'][0]['driver']);
    }
}
