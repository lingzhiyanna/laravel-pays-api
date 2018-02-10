<?php

namespace DavidNineRoc\Payment;

class Config
{
    protected $config = [];

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            $this->setConfig($key, $value);
        }
    }


    /**
     * 设置 uid 您的商户唯一标识，注册后在设置里获得。一个24位字符串
     * @param $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->setConfig('uid', $uid);

        return $this;
    }

    /**
     * 设置商品价格 单位：元。精确小数点后2位
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->setConfig('price', $price);

        return $this;
    }

    /**
     * 设置付款方式 1：支付宝；2：微信支付
     * @param $type
     * @return $this
     */
    public function setPayType($type)
    {
        $this->setConfig('istype', $type);

        return $this;
    }

    /**
     * 设置通知回调网址
     * 用户支付成功后，我们服务器会主动发送一个post消息到这个网址
     * @param $notifyUrl
     * @return $this
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->setConfig('notify_url', $notifyUrl);

        return $this;
    }

    /**
     * 设置跳转网址
     * 用户支付成功后，我们会让用户浏览器自动跳转到这个网址
     * @param $returnUrl
     * @return $this
     */
    public function setReturnUrl($returnUrl)
    {
        $this->setConfig('return_url', $returnUrl);

        return $this;
    }

    /**
     * 设置商户自定义订单号
     * 我们会据此判别是同一笔订单还是新订单。回调时，会带上这个参数
     * @param $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->setConfig('orderid', $orderId);

        return $this;
    }

    /**
     * 设置商户自定义客户号
     * 我们会显示在您后台的订单列表中，方便您看到是哪个用户的付款
     * 强烈建议填写。可以填用户名也可以填您数据库中的用户uid
     * @param $uid
     * @return $this
     */
    public function setOrderUid($uid)
    {
        $this->setConfig('orderuid', $uid);

        return $this;
    }

    /**
     * 设置商品名字
     * @param $goodsName
     * @return $this
     */
    public function setGoodsName($goodsName)
    {
        $this->setConfig('goodsname', $goodsName);

        return $this;
    }

    /**
     * 设置一个配置选项
     * @param $key
     * @param $value
     */
    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;
    }
}