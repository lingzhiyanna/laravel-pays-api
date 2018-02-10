<?php

return [
    /*
     * PaysApi 账户中的 uid
     */
    'uid' => env('PAYS_API_UID'),

    /*
     * PaysApi 账户中的 token
     */
    'token' => env('PAYS_API_TOKEN'),


    /*
     * 付款成功后台通知地址
     */
    'notify_url' => env('PAYS_API_NOTIFY_URL'),

    /*
     * 付款成功前台跳转页面
     */
    'return_url' => env('PAYS_API_RETURN_URL'),
];
