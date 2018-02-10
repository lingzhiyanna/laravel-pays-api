<?php

namespace App\Http\Controllers;


use DavidNineRoc\Payment\PaysApi;

class HelloController extends ApiController
{
    /**
     * 使用依赖注入的方式支付
     * @param \DavidNineRoc\Payment\PaysApi $paysApi
     * @return string
     */
    public function pay(PaysApi $paysApi)
    {
        return $paysApi->setPrice(9)
            ->setGoodsName('大卫')
            ->setPayType(1)
            ->pay();


    }

    /**
     * 通过门面的方式支付
     * @return mixed
     */
    public function payByFacade()
    {
        return \PaysApi::setPrice(9)
            ->setGoodsName('大卫')
            ->setPayType(1)
            ->pay();
    }

    /**
     * 异步的方式支付
     * @param \DavidNineRoc\Payment\PaysApi $paysApi
     * @return string
     */
    public function syncPay(PaysApi $paysApi)
    {
        return $paysApi->setPrice(9)
            ->setGoodsName('大卫')
            ->setPayType(1)
            ->syncPay();
    }
}
