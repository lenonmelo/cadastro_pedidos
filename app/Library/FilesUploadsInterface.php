<?php

/**
 * Classe de interface para realizar upload e delete de arquivos
 */

namespace App\Library;

use App\Models\User;
use Illuminate\Http\File;

interface FilesUploadsInterface
{
    public function upload(File $file);

    public function delete($fileName);
}
