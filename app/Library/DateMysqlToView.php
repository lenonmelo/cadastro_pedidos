<?php

/**
 * Classe que realiza a conversão de datas no formato mySql (yyyy-mm-dd) para o formato brasileiro (dd/mm/yyyy)
 */

namespace App\Library;

use DateTime;
use Exception;

class DateMysqlToView implements DateConverterInterface
{
    public function converter($dateAndDateTime)
    {
        try {
            // Criar um objeto DateTime com a data no formato mysql
            $dataObj = DateTime::createFromFormat('Y-m-d', $dateAndDateTime);

            // Verifique se a criação do objeto foi bem-sucedida
            if ($dataObj instanceof DateTime) {
                // Retorna a data no formato brasileiro
                return $dataObj->format('d/m/Y');
            } else {
                // Caso o formato passado como parâmetro seja incorreto, retorna falso
                return false;
            }
        } catch (Exception $e) {
            return "Erro ao realizar conversão da data Mysql para o formato brasileiro - " . $e->getMessage();
        }
    }
}
