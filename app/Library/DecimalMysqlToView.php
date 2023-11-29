<?php

/**
 * Classe que realiza a conversão de valores no formato Mysql (xxxx.xx) para o formato brasileiro (x.xxx,xx)
 */

namespace App\Library;

use Exception;

class DecimalMysqlToView implements DecimalConverterInterface
{
    public function converter($decimalValue)
    {
        try {
            return number_format($decimalValue, 2, ',', '.');;
        } catch (Exception $e) {
            return "Erro ao realizar a conversãodo valor - " . $e->getMessage();
        }
        return false;
    }
}
