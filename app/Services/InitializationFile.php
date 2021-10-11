<?php

namespace App\Services;

use App\Models\File;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InitializationFile extends Service
{
    public function __construct()
    {
    }

    public function execute()
    {
    }

    public function save($file)
    {
        $save = new File();
        try {
            $data = Storage::putFile(
                'public',
                $file,
            );
            $save->name = $data;
            $save->type = $file->extension();
            $save->save();
        } catch (Exception $e) {
            return null;
        }
        return $save->id;
    }
}
