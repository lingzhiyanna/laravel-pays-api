<?php

namespace DavidNineRoc\Payment\Foundation;

class Util
{
    /**
     * 根据参数值，生成 key => value 的表单.
     *
     * @param $config
     *
     * @return string
     */
    public static function buildFormHtml($url, $config)
    {
        $form = "<form id='pay_form' action='{$url}' method='post'>";
        foreach ($config as $key => $value) {
            $form .= "<input type='hidden' name='{$key}' value='{$value}'/>";
        }
        $form .= '</form>';

        return $form."<script>document.querySelector('#pay_form').submit();</script>";
    }
}
