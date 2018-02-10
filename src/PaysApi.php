<?php

namespace DavidNineRoc\Payment;

use DavidNineRoc\Payment\Foundation\Config;
use DavidNineRoc\Payment\Foundation\Http;
use DavidNineRoc\Payment\Foundation\Util;

class PaysApi
{
    use Config;

    /**
     * 支付接口.
     *
     * @var string
     */
    protected $payUrl = 'https://pay.paysapi.com/';

    /**
     * 异步支付接口.
     *
     * @var string
     */
    protected $syncPayUrl = 'https://pay.paysapi.com/?format=json';

    /**
     * 支付操作.
     *
     * @return string
     */
    public function pay()
    {
        return Util::buildFormHtml(
            $this->payUrl,
            $this->buildPayConfig()
        );
    }

    public function verify(Config $config)
    {
    }

    /**
     * 异步请求支付.
     * @return mixed
     */
    public function syncPay()
    {
        return Http::post(
            $this->syncPayUrl,
            $this->buildPayConfig(),
            function ($error) {
                return [
                    'code' => 400,
                    'msg' => $error,
                ];
            }
        );
    }

}
