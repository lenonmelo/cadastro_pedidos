<?php

/**
 * Classe que realiza a conversão de datas no formato PR-br (dd/mm/yyyy) para o formato Mysql (yyyy-mm-dd)
 */

namespace App\Library;

use DateTime;
use Exception;

class DateViewToMysql implements DateConverterInterface
{
    public function converter($dateAndDateTime)
    {
        try {
            // Criar um objeto DateTime com a data no formato brasileiro
            $dataObj = DateTime::createFromFormat('d/m/Y', $dateAndDateTime);

            // Verifique se a criação do objeto foi bem-sucedida
            if ($dataObj instanceof DateTime) {
                // Retorna a data no formato MySQL
                return $dataObj->format('Y-m-d');
            } else {
                // Caso o formato passado como parâmetro seja incorreto, retorna falso
                return false;
            }
        } catch (Exception $e) {
            return "Erro ao realizar conversão da data no formato brasileiro para o formato mysql - " . $e->getMessage();
        }
    }
}
