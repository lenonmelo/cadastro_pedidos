<?php

/**
 * Classe con funcionalidades para manipulação de arquivos de pedidos
 */

namespace App\Library;

use Exception;
use Intervention\Image\Facades\Image;

class FilesPedidos implements FilesUploadsInterface
{
    /*
    * Realiza o upload de imagens na pasta original e cria a capa da mesma
    */
    public function upload($file)
    {
        try {
            // Nome do arquivo é composto por ano, mês, dia, hora, minuto, segundo com o nome do veículo
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Realiza o upload na pasta app/images/original
            $file->storeAs('images/original', $fileName);

            // Realiza o upload na pasta app/images/capa
            $image = Image::make(storage_path("app/images/original/{$fileName}"))
                ->resize(90, 100) // Defina as dimensões desejadas
                ->save(storage_path("app/images/capa/{$fileName}"));

            return $fileName;
        } catch (Exception $e) {
            return "Erro ao realizar o upload de imagem - " . $e->getMessage();
        }
    }

    /*
    * Delete os arquivos da pasta original e da pasta capa
    */
    public function delete($fileName)
    {
        try {
            //Pega localização do arquivo original para ser excluido
            $storagePatchOriginal = storage_path("app/images/original/{$fileName}");
            // Verifica se o arquivo original existe
            if (file_exists($storagePatchOriginal)) {
                // Caso exista, remove o arquivo original
                if (unlink($storagePatchOriginal)) {
                    //Pega localização do arquivo de capa para ser excluido
                    $storagePatchCapa = storage_path("app/images/capa/{$fileName}");
                    // Verifica se o arquivo de capa existe
                    if (file_exists($storagePatchCapa)) {
                        // Caso exista, remove o arquivo de capa
                        if (unlink($storagePatchCapa)) {
                            return true;
                        }
                    }
                }
            }

            return false;
        } catch (Exception $e) {
            return "Erro ao realizar a remoção de imagens - " . $e->getMessage();
        }
    }
}
