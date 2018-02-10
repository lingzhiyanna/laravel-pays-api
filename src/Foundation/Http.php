<?php

namespace DavidNineRoc\Payment\Foundation;


class Http
{
    /**
     * 发送一个 http get 请求
     * @param $url
     * @param array $parameters
     * @param $errorFunc
     * @return string
     */
    public static function get($url, $parameters = [], $errorFunc)
    {
        if (! empty($parameters)) {
            $url .= '?' . http_build_query($parameters);
        }

        // 启动一个CURL会话
        $curl = curl_init();
        // 要访问的地址
        curl_setopt($curl, CURLOPT_URL, $url);
        // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if ($error = curl_errno($curl)) {
            return $errorFunc($error);
        }
        curl_close($curl);

        return $result;
    }

    /**
     * 发送一个 Http post 请求
     *
     * @param $url
     * @param $parameters
     * @param $errorFunc
     * @param int $timeout
     *
     * @return mixed
     */
    public static function post($url, $parameters, $errorFunc, $timeout = 5)
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
