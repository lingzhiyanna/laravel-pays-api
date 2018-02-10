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
use Illuminate\Http\Request;

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
    
    /**
     * 验证付款成功回调通知
     * 必须调用 setOptions，把所有参数传入
     * 之后可以调用 verify 验证是否通过
     * @param PaysApi $paysApi
     * @param Request $request
     */
    public function verify(PaysApi $paysApi, Request $request)
    {
        $paysApi
            ->setOptions($request->all())
            ->verify(
                function () {
                    // 验证通过，写入数据库

                },
                function () {
                    // 验证不通过, 写入日志
                }
            );

        // 当然，你也可以用这种方式
        if ($paysApi->setOptions($request->all())->verify()) {
            // 验证通过，写入数据库
        } else {
            // 验证不通过, 写入日志
        }
    }
    
     /**
     * 跳转到正常页面
     * @param Request $request
     */
    public function returnUrl(Request $request)
    {
        dd($request->input('orderid'));
    }
}

```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).