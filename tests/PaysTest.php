<?php

use DavidNineRoc\Payment\PaysApi;

class PaysTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        parent::setUp();

        if (! function_exists('env')) {
            function env($key, $default = '')
            {
                return md5(
                    time()
                );
            }
        }
    }

    public function testPaysObject()
    {
        $paysApi = new PaysApi();
        $paysApi->setOptions(
            require __DIR__.'/../config/paysapi.php'
        );

        $this->assertNotNull($paysApi);

        return $paysApi;
    }

    /**
     * @depends testPaysObject
     * @param PaysApi $paysApi
     */
    public function testApi(PaysApi $paysApi)
    {
        $this->assertFalse($paysApi->verify());
    }

    /**
     * @depends testPaysObject
     */
    public function testResultJson()
    {
        // 重新设置秘钥，不要同时进行两次操作
        $paysApi = $this->testPaysObject();
        $this->assertJson(
            $paysApi->syncPay()
        );
    }
}
