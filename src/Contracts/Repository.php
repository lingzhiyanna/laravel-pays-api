<?php

namespace DavidNineRoc\Payment\Contracts;

interface Repository
{
    /**
     * 设置一个 item。
     * @param $key
     * @param $value
     */
    public function set($key, $value);

    /**
     * 获取一个 item，不存在时返回默认值。
     * @param $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = '');

    /**
     * 是否存在 item。
     * @param $key
     * @return bool
     */
    public function has($key);

    /**
     * 删除一个 item
     * @param $key
     */
    public function delete($key);
}