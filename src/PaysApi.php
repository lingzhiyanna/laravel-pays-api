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
     * 异步请求支付
     * @param Config $config
     * @return mixed
     */
    public function syncPay(Config $config)
    {
        return $this->httpPost(
            $this->syncPayUrl,
            $config->buildPayConfig(),
            function ($error) {
                return [
                    'code' => 400,
                    'msg' => $error
                ];
            }
        );
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

    /**
     * 发送一个 Http post 请求
     * @param $url
     * @param $parameters
     * @param $errorFunc
     * @param int $timeout
     * @return mixed
     */
    protected function httpPost($url, $parameters, $errorFunc, $timeout = 5)
    {
        // 启动一个CURL会话
        $curl = curl_init();
        // 要访问的地址
        curl_setopt($curl, CURLOPT_URL, $url);
        // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POST, 1);
        // Post提交的数据包
        curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if ($error = curl_errno($curl)) {
            return $errorFunc($error);
        }
        curl_close($curl);

        return $result;
    }
}
