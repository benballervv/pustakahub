<?php

namespace Config;

use Midtrans\Config as MidtransConfig;

class Midtrans
{
    public static function init()
    {
        MidtransConfig::$serverKey = env('MIDTRANS_SERVER_KEY');

        MidtransConfig::$clientKey = env('MIDTRANS_CLIENT_KEY');

        MidtransConfig::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';

        MidtransConfig::$isSanitized = true;

        MidtransConfig::$is3ds = true;
    }
}