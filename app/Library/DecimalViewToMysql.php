<?php

/**
 * Classe que realiza a conversão de valores no formato brasileiro (x.xxx,xx) para o formato Mysql (xxxx.xx)
 */

namespace App\Library;

use Exception;

class DecimalViewToMysql implements DecimalConverterInterface
{
    public function converter($decimalValue)
    {
        try {
            return str_replace(['.', ','], ['', '.'], $decimalValue);
        } catch (Exception $e) {
            return "Erro ao realizar a conversãodo valor - " . $e->getMessage();
        }
    }
}
