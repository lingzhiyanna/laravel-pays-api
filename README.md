# laravel-pays-api
<p align="center">
<a href="https://travis-ci.org/DavidNineRoc/laravel-pays-api"><img src="https://travis-ci.org/DavidNineRoc/laravel-pays-api.svg?branch=master" alt="Travis CI"></a>
<a href="https://styleci.io/repos/120973265"><img src="https://styleci.io/repos/120973265/shield?branch=master" alt="StyleCI"></a>
<a href="https://packagist.org/packages/davidnineroc/laravel-pays-api"><img src="https://poser.pugx.org/davidnineroc/laravel-pays-api/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidnineroc/laravel-pays-api"><img src="https://poser.pugx.org/davidnineroc/laravel-pays-api/license" alt="License"></a>
</p> 

****
[PaysApi支付](https://www.paysapi.com)
## Install
```php
composer require davidnineroc/laravel-pays-api
```
## PHP && Example
```php
<?php

require __DIR__.'/vendor/autoload.php';


/****************************************
 * 在原生 PHP 中使用，请记得设置token,uid等配置
 * 可以通过 setOptions 一次性设置多个
 * 例子中的等效这个链式调用
 * $paysApi->setUid()->setToken()->setNotifyUrl()->setReturnUrl();
*/
$systemConfig = [
    // PaysApi 账户中的 uid
    'uid' => 'xxxx',
    // PaysApi 账户中的 token
    'token' => 'xxx',
    // 付款成功后台通知地址
    'notify_url' => 'http://localhost:8000/notify',
    // 付款成功前台跳转页面
    'return_url' => 'http://localhost:8000/notify',
];

$paysApi = new \DavidNineRoc\Payment\PaysApi();
$paysApi->setOptions($systemConfig);

/****************************************
 * 支付相关的配置
 * 商品价格
 * 商品名字
 * 订单类型：默认为1，支付宝
 * 商品订单号： 不传则自动生成
 */
$response = $paysApi->setPrice(9)
                    ->setGoodsName('大卫')
                    ->setPayType(2)
                    ->setOrderUid(
                        md5(time())
                    )
                    ->pay();
// 将产生一个自动提交的表单
echo $response;

/****************************************
 *  异步支付，返回json
 */
$response = $paysApi->setPrice(9)
    ->setGoodsName('大卫')
    ->setPayType(2)
    ->setOrderUid(
        md5(time())
    )
    ->syncPay();

echo $response;

/****************************************
 *  判断是否成功付款
 */
$paysApi->setOptions($_REQUEST)->verify(function () {
    // 成功，写入数据库
}, function () {
    // 失败，写入日志
});
// 也可以这样子调用
if ($paysApi->setOptions($_REQUEST)->verify()) {
    // 成功，写入数据库
} else {
    // 失败，写入日志
}

/****************************************
 *  查找订单号
 */
$orderId = '12345678910';
$order = $paysApi->find($orderId);
// json 数据
var_dump($order);
```
## Laravel && Example
* 发布配置文件(配置好之后再进行下一步)
```php
php artisan vendor:publish --provider=DavidNineRoc\Payment\PaysApiServiceProvider
```
* 尽情的使用吧！！！
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
        // json 字符串
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
      * 查找订单
      * @param PaysApi $paysApi
      */
     public function queryOrder(PaysApi $paysApi)
     {
         $orderId = '12345678910';
         
         // json 字符串
         dd($paysApi->find($orderId));
     }
}

```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
