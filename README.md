# laravel-pays-api
[PaysApi支付](https://www.paysapi.com)

****
## Example
```php
<?php

namespace App\Http\Controllers;

use DavidNineRoc\Payment\PaysApi;

class PayController extends Controller
{
    /**
     * 使用依赖注入的方式
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
     * 使用门面的方式
     * 建议使用依赖注入的方式
     */
    public function useFacedeWay()
    {
        
    }
}

```