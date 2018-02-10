<?php

use DavidNineRoc\Payment\PaysApi;

class PaysTest extends \PHPUnit\Framework\TestCase
{
    public function testApi()
    {
        $this->assertFalse((new PaysApi())->verify());
    }
}