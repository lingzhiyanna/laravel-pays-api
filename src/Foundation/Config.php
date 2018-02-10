<?php

namespace DavidNineRoc\Payment\Foundation;

use DavidNineRoc\Payment\Exceptions\ConfigException;

trait Config
{
    protected $config = [];

    /**
     * 订单必须的配置参数.
     *
     * @var array
     */
    protected $payConfig = [
        // 完整的参数列表
        'full' => [
            'uid',
            'price',
            'istype',
            'notify_url',
            'return_url',
            'orderid',
            'orderuid',
            'goodsname',
            'key',
        ],
        // 必须的参数列表
        'require' => [
            'uid',
            'price',
            'istype',
            'notify_url',
            'return_url',
            'orderid',
            'key',
        ],
    ];

    /**
     * 一次性设置多个配置项.
     *
     * @param array $config
     *
     * @return $this
     */
    public function setOptions(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * 设置 uid 您的商户唯一标识，注册后在设置里获得。一个24位字符串。
     *
     * @param $uid
     *
     * @return $this
     */
    public function setUid($uid)
    {
        $this->set('uid', $uid);

        return $this;
    }

    /**
     * 设置 token。
     *
     * @param $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->set('token', $token);

        return $this;
    }

    /**
     * 设置商品价格 单位：元。精确小数点后2位。
     *
     * @param $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->set('price', $price);

        return $this;
    }

    /**
     * 设置付款方式 1：支付宝；2：微信支付。
     *
     * @param $type
     *
     * @return $this
     */
    public function setPayType($type)
    {
        $this->set('istype', $type);

        return $this;
    }

    /**
     * 设置通知回调网址。
     * 用户支付成功后，我们服务器会主动发送一个post消息到这个网址。
     *
     * @param $notifyUrl
     *
     * @return $this
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->set('notify_url', $notifyUrl);

        return $this;
    }

    /**
     * 设置跳转网址。
     * 用户支付成功后，我们会让用户浏览器自动跳转到这个网址。
     *
     * @param $returnUrl
     *
     * @return $this
     */
    public function setReturnUrl($returnUrl)
    {
        $this->set('return_url', $returnUrl);

        return $this;
    }

    /**
     * 设置商户自定义订单号。
     * 我们会据此判别是同一笔订单还是新订单。回调时，会带上这个参数。
     *
     * @param $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->set('orderid', $orderId);

        return $this;
    }

    /**
     * 设置商户自定义客户号。
     * 我们会显示在您后台的订单列表中，方便您看到是哪个用户的付款，
     * 强烈建议填写。可以填用户名也可以填您数据库中的用户uid。
     *
     * @param $uid
     *
     * @return $this
     */
    public function setOrderUid($uid)
    {
        $this->set('orderuid', $uid);

        return $this;
    }

    /**
     * 设置商品名字。
     *
     * @param $goodsName
     *
     * @return $this
     */
    public function setGoodsName($goodsName)
    {
        $this->set('goodsname', $goodsName);

        return $this;
    }

    /**
     * 生成秘钥，
     * 把使用到的所有参数，连Token一起，
     * 按参数名字母升序排序。把参数值拼接在一起。
     * 做md5-32位加密，取字符串小写。得到key。
     * 网址类型的参数值不要urlencode。
     */
    protected function generateSignKey()
    {
        $config = $this->config;
        // 删除掉 key
        $this->delete('key');
        // 加上 token
        $this->set('token', $this->get('token'), false);
        // 按参数名字母升序排序
        ksort($config);
        // 把参数值拼接在一起
        $key = implode('', $config);
        // 做md5-32位加密，取字符串小写。得到key
        $key = strtolower(
            md5($key)
        );

        $this->set('key', $key);
    }

    /**
     * 删除配置中的某一项。
     *
     * @param $key
     */
    public function delete($key)
    {
        if (array_key_exists($key, $this->config)) {
            unset($this->config[$key]);
        }
    }

    /**
     * 获取一个配置项。
     *
     * @param $key
     * @param string $default
     *
     * @return string
     */
    public function get($key, $default = '')
    {
        if ($this->has($key)) {
            $value = $this->config[$key];
        } else {
            $value = $default;
        }

        return $value;
    }

    /**
     * 配置中是否存在这个项。
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * 设置一个配置选项，
     * 设置 $cover 为 false 之后，
     * 当存在一个 key 不会覆盖。
     *
     * @param $key
     * @param $value
     * @param bool $cover
     */
    public function set($key, $value, $cover = true)
    {
        // 如果不强制覆盖，当存在时，则跳过
        if (!$cover && $this->has($key)) {
            return;
        }

        $this->config[$key] = $value;
    }

    /**
     * 只获取配置中的某些选项。
     *
     * @param $keys
     *
     * @return array
     */
    public function only($keys)
    {
        return array_intersect_key($this->config, array_flip((array) $keys));
    }

    /**
     * 方便门面方式获取自己.
     *
     * @return $this
     */
    public function getInstance()
    {
        return $this;
    }

    /**
     * 生成支付所需的参数。
     *
     * @return array
     */
    public function buildPayConfig()
    {
        // 处理必须的配置
        $this->setPayDefaultConfig();

        // 先生成秘钥
        $this->generateSignKey();

        // 取到支付所需的所有参数
        $config = $this->only(
            $this->payConfig['full']
        );

        $this->checkConfigIsFull(
            $config,
            $this->payConfig['require']
        );

        return $config;
    }

    /**
     * 如果有些参数没有设置，而又可以系统生成
     * 那么就让系统生成这些默认参数。
     */
    protected function setPayDefaultConfig()
    {
        if (!$this->has('price')) {
            $this->setPrice(0.01);
        }

        // 默认支付宝支付
        if (!$this->has('istype')) {
            $this->setPayType(1);
        }

        // 建议自己生成 uuid
        if (!$this->has('orderid')) {
            $this->setOrderId(
                md5(microtime())
            );
        }
    }

    /**
     * 检查参数是否符合了 $requireConfig 中所有的值
     *
     * @param $config
     * @param $requireConfig
     *
     * @throws ConfigException
     */
    protected function checkConfigIsFull($config, $requireConfig)
    {
        $keys = array_keys($config);

        $diff = array_diff($requireConfig, $keys);
        // 如果不为空，代表所需参数不齐全
        if (!empty($diff)) {
            throw new ConfigException(
                '缺少参数，分别是：['.implode('], [', $diff).']'
            );
        }
    }
}
