<?php

namespace DavidNineRoc\Payment;

class PaysApi
{
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
     * @param array $config
     *
     * @return string
     */
    public function pay(Config $config)
    {
        return $this->buildFormHtml($config->buildPayConfig());
    }

    /**
     * 根据参数值，生成 key => value 的表单.
     *
     * @param $config
     *
     * @return string
     */
    protected function buildFormHtml($config)
    {
        $form = "<form id='pay_form' action='{$this->payUrl}' method='post'>";
        foreach ($config as $key => $value) {
            $form .= "<input type='hidden' name='{$key}' value='{$value}'/>";
        }
        $form .= '</form>';

        return $form."<script>document.querySelector('#pay_form').submit();</script>";
    }
}
