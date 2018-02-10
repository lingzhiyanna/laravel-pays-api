# laravel-pays-api
[PaysApi支付](https://www.paysapi.com)

****
## Example
```php
<?php

namespace App\Http\Controllers;


use DavidNineRoc\Payment\Contracts\Repository;
use DavidNineRoc\Payment\PaysApi;

class PayController extends Controller
{
    /**
     * 使用依赖注入的方式
     * @param \DavidNineRoc\Payment\PaysApi $paysApi
     * @param \DavidNineRoc\Payment\Contracts\Repository $config
     * @return string
     */
    public function useDependency(PaysApi $paysApi, Repository $config)
    {
        $config->setPrice(9)
            ->setGoodsName('大卫')
            ->setPayType(1);

        return $paysApi->pay($config);
    }
    
     /**
     * 使用门面的方式
     * 建议使用依赖注入的方式
     */
    public function useFacedeWay()
    {
        /**
         * 如果不是依赖注入的方式，
         * 需要手动添加 uid, token 等配置。
         */
        $config = new Config(
            config('paysapi')
        );
        $config->setPrice(9)
            ->setGoodsName('大卫')
            ->setPayType(1);

        return \PaysApi::pay(
            $config
        );
        }
}

```