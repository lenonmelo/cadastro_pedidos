<?php

/**
 * Classe que realiza a validação da data de nascimento, não deverá ser maior que a data atual
 */

namespace App\Library;

use DateTime;

class DataNascimentoValidation implements DateValidationInterface
{
  public function validate($dateAndDateTime)
  {

    // Criar um objeto DateTime com a data no formato brasileiro
    $dataObj = DateTime::createFromFormat('d/m/Y', $dateAndDateTime);
    $dataAtual = new DateTime();

    //Caso a data for maior que a data atual, retorna falso
    if ($dataObj > $dataAtual) {
      return  false;
    }

    return true;
  }
}
