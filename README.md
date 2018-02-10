# laravel-pays-api
<p align="center">
<a href="https://styleci.io/repos/120973265"><img src="https://styleci.io/repos/120973265/shield?branch=master" alt="StyleCI"></a>

<a href="https://packagist.org/packages/davidnineroc/laravel-pays-api"><img src="https://poser.pugx.org/davidnineroc/laravel-pays-api/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/davidnineroc/laravel-pays-api"><img src="https://poser.pugx.org/davidnineroc/laravel-pays-api/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidnineroc/laravel-pays-api"><img src="https://poser.pugx.org/davidnineroc/laravel-pays-api/license" alt="License"></a>
</p> 

****
[PaysApi支付](https://www.paysapi.com)
## Example
```php
<?php

namespace App\Http\Controllers;

use DavidNineRoc\Payment\PaysApi;

class PayController extends Controller
{
    /**
     * 使用依赖注入的方式支付.
     *
     * @param \DavidNineRoc\Payment\PaysApi $paysApi
     *
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
     * 通过门面的方式支付.
     *
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
     * 异步的方式支付.
     *
     * @param \DavidNineRoc\Payment\PaysApi $paysApi
     *
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

```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).