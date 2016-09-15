<?php

namespace app\Helpers;

use App\Helpers\Contracts\SkuContract;

class Sku implements SkuContract
{

    public function generateSku()
    {

        return rand(100000000000, 999999999999);

    }

}
