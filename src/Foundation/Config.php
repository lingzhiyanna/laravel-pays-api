<?php

namespace DavidNineRoc\Payment\Foundation;

use DavidNineRoc\Payment\Exceptions\ConfigException;

trait Config
{
    /**
     * 参数配置的容器.
     *
     * @var array
     */
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
     * 回调后台通知包含的参数.
     *
     * @var array
     */
    protected $notifyConfig = [
        'full' => [
            'paysapi_id',
            'orderid',
            'price',
            'realprice',
            'orderuid',
            'key',
            'token',
        ],
        'require' => [
            'paysapi_id',
            'orderid',
            'price',
            'realprice',
            'key',
            'token',
        ],
    ];

    protected $queryConfig = [
        'full' => ['uid', 'orderid', 'r', 'token'],
        'require' => ['uid', 'orderid', 'r', 'key'],
    ];

    /************************************
     * 设置配置的函数.
     * 一次性设置多个配置项
     * @param array $config
     *
     * @return $this
     ************************************
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
     * 设置一个项为随机值
     *
     * @param $key
     */
    public function setRandom($key)
    {
        $this->set($key, md5(microtime()));
    }

    /**
     * 设置秘钥参数.
     *
     * @param $key
     *
     * @return $this
     */
    protected function setKey($key)
    {
        $this->set('key', $key);

        return $this;
    }

    /************************************
     * 设置，删除，查询，获取 参数的方法
     * 删除配置中的某一项。
     ************************************
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
     * 删除一个配置项.
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
     * 获取并删除配置.
     *
     * @param $key
     * @param string $default
     *
     * @return string
     */
    public function pull($key, $default = '')
    {
        $value = $this->get($key, $default);
        $this->delete($key);

        return $value;
    }

    /**
     * 只获取配置中的某些选项。
     *
     * @param $keys
     *
     * @return array
     */
    protected function only($keys)
    {
        return $this->config = array_intersect_key($this->config, array_flip((array) $keys));
    }

    /************************************
     * 生成支付所需的参数。
     * 1. 先去设置必须包含，但又没有给的参数
     *    如订单号，可以系统生成
     * 2. 生成密钥
     *    对所有参数加密排序
     * 3. 检查配置项目是否合法，
     *    uid，token 没有会抛出异常
     * 4. 返回一个可以生成订单的数组配置
     * @return array
     ************************************
     */
    protected function buildPayConfig()
    {
        // 处理必须的配置
        $this->setPayDefaultConfig();

        // 生成秘钥
        $this->setKey(
            $this->generateSignKey(
                $this->config
            )
        );

        // 支付所需的所有参数
        $this->only(
            $this->payConfig['full']
        );

        $this->checkConfigIsFull(
            $this->config,
            $this->payConfig['require']
        );

        return $this->config;
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
            $this->setRandom('orderid');
        }
    }

    /**
     * 生成秘钥，
     * 把使用到的所有参数，连Token一起，
     * 按参数名字母升序排序。把参数值拼接在一起。
     * 做md5-32位加密，取字符串小写。得到key。
     * 网址类型的参数值不要urlencode。
     *
     * @param $config
     *
     * @return string
     */
    protected function generateSignKey($config)
    {
        // 按参数名字母升序排序
        ksort($config);
        // 把参数值拼接在一起
        $key = $this->catAndEncode($config);

        return $key;
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
        // 取出值为空的项再验证
        $config = array_filter($config);

        $keys = array_keys($config);

        $diff = array_diff($requireConfig, $keys);
        // 如果不为空，代表所需参数不齐全
        if (!empty($diff)) {
            throw new ConfigException(
                '缺少参数，分别是：['.implode('], [', $diff).']'
            );
        }
    }

    /************************************
     * 检查 Notify 参数的合法性，确定是从
     * 支付接口传过来的消息
     ************************************
     */
    protected function verifyNotifyValidity()
    {
        $this->only($this->notifyConfig['full']);

        // 检查参数合法性
        try {
            $this->checkConfigIsFull($this->config, $this->notifyConfig['require']);
        } catch (ConfigException $e) {
            return false;
        }

        // 获取并弹出秘钥
        $key = $this->pull('key');

        // 生成秘钥
        $sign = $this->generateSignKey($this->config);

        return $key === $sign;
    }

    /************************************
     * 检查 Notify 参数的合法性，确定是从
     * 支付接口传过来的消息
     ************************************
     */
    protected function buildQueryConfig()
    {
        // 设置为随机值
        $this->setRandom('r');
        $this->only($this->queryConfig['full']);

        // 生成 key
        $this->setKey(
            $this->catAndEncode(
                $this->getQueryConfigOrder()
            )
        );

        // 删除 token
        $this->delete('token');

        $this->checkConfigIsFull(
            $this->config,
            $this->queryConfig['require']
        );

        return $this->config;
    }

    /**
     * 获取按照 queryConfig['full'] 里的值
     * 排序后的配置项.
     *
     * @return array
     */
    protected function getQueryConfigOrder()
    {
        $config = [];
        foreach ($this->queryConfig['full'] as $key) {
            $config[$key] = $this->config[$key];
        }

        return $this->config = $config;
    }

    /**
     * 拼接，md5 加密，转小写.
     *
     * @param $array
     *
     * @return string
     */
    protected function catAndEncode($array)
    {
        $string = implode('', $array);
        $string = md5($string);

        return strtolower($string);
    }
}
