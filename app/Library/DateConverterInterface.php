<?php

/**
 * Classe de interface para realizar conversões de datas
 */

namespace App\Library;

use App\Models\User;

interface DateConverterInterface
{
    public function converter($dateAndDateTime);
}
