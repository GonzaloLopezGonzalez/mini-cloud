<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use App\Helpers\FileHelper;
use Carbon\Carbon;
use Illuminate\Support\Str;

class File
{
    private $allowedTypes;
    private $maxFileSize;

    public function __construct()
    {
       $this->allowedTypes = FileHelper::allowedMimetypes();

        $this->maxFileSize = 5 * 1024 * 1024; // 5MB

        $this->comprobatDirectoriosSubidas();
    }

    private function comprobatDirectoriosSubidas()
    {
        // Asegúrate de que el directorio de subida exista (config/filesystem)
        if (!Storage::disk('uploads')->exists('')) {
            Storage::disk('uploads')->makeDirectory('');
        }

        if (!Storage::disk('uploadsImages')->exists('')) {
            Storage::disk('uploadsImages')->makeDirectory('');
        }

        if (!Storage::disk('uploadsImagesGallery')->exists('')) {
            Storage::disk('uploadsImagesGallery')->makeDirectory('');
        }

        if (!Storage::disk('uploadsPdf')->exists('')) {
            Storage::disk('uploadsPdf')->makeDirectory('');
        }

        if (!Storage::disk('uploadsDoc')->exists('')) {
            Storage::disk('uploadsDoc')->makeDirectory('');
        }

        if (!Storage::disk('uploadsXls')->exists('')) {
            Storage::disk('uploadsXLS')->makeDirectory('');
        }

        if (!Storage::disk('uploadsZip')->exists('')) {
            Storage::disk('uploadsZip')->makeDirectory('');
        }
    }

    private function getExtensionFileFromString($file)
    {
        $array = explode('.', $file);
        return end($array);
    }

    private function getFilePath($file)
    {
       $extension = $this->getExtensionFileFromString($file);
       $extension = strtolower($extension);
       $path = '';
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $path = 'uploadsImages';
                break;
            case 'pdf':
                $path = 'uploadsPdf';
                break;
            case 'txt':
            case 'doc':
                $path = 'uploadsDoc';
                break;
            case 'xls':
                $path = 'uploadsXls';
                break;
            case 'zip':
                $path = 'uploadsZip';
                break;

            }
        return $path;
    }

    public function downloadFile($file)
    {
        $storagePath = $this->getFilePath($file);

        // Ruta al archivo en el storage
        if (Storage::disk($storagePath)->exists($file)) {
                return Storage::disk($storagePath)->path($file);
        }
        return false;
    }

    private function uploadFile($file)
    {
       $fileName = $file->getClientOriginalName();
       $extension = strtolower($file->guessExtension());
       $fileName = Str::slug($fileName);

       $path = '';
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $path = $file->storeAs('', $fileName, 'uploadsImages');
                $storagePath = $this->getFilePath($file);
                $fileToReduce = Storage::disk('uploadsImages')->path($path);
                $fileToReduced = Storage::disk('uploadsImagesGallery')->path($path);
               FileHelper::reduceImageSize($fileToReduce, $fileToReduced, 500, 500);
                break;
            case 'pdf':
                $path = $file->storeAs('', $fileName, 'uploadsPdf');
                break;
            case 'txt':
            case 'doc':
                $path = $file->storeAs('', $fileName, 'uploadsDoc');
                break;
            case 'xls':
                $path = $file->storeAs('', $fileName, 'uploadsXls');
                break;
            case 'zip':
                $path = $file->storeAs('', $fileName, 'uploadsZip');
                break;
            }
        return $path;
    }

    public function uploadMultipleFiles($files)
    {
        $results = [];
        
        foreach ($files as $file) {
            // Validar el archivo
            if (!$file->isValid()) {
                $results[] = [
                    'success' => false,
                    'message' => "Error al subir {$file->getClientOriginalName()}: {$file->getErrorMessage()}"
                ];
                continue;
            }

            if ($file->getSize() > $this->maxFileSize) {
                $results[] = [
                    'success' => false,
                    'message' => "El archivo {$file->getClientOriginalName()} excede el tamaño máximo permitido."
                ];
                continue;
            }

            if (!in_array($file->getClientMimeType(), $this->allowedTypes)) {
                $results[] = [
                    'success' => false,
                    'message' => "El tipo de archivo {$file->getClientOriginalName()} no está permitido."
                ];
                continue;
            }

            // Sanitizar el nombre del archivo
            $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $path = $this->uploadFile($file);

            if (!empty($path)) {
                $results[] = [
                    'success' => true,
                    'message' => "Archivo {$file->getClientOriginalName()} subido correctamente.",
                    'file_name' => $fileName
                ];
            } else {
                $results[] = [
                    'success' => false,
                    'message' => "Error al mover el archivo {$file->getClientOriginalName()}."
                ];
                }
        }

        return $results;
    }

    public function imageGallery()
    {
        $files = [];
        $fileList = Storage::disk('uploadsImagesGallery')->files('');
        foreach ($fileList as $file) {
            $files[] = [
                'name' => basename($file),
                'ruta' => Storage::disk('uploadsImagesGallery')->url($file)
            ];
        }

        return $files;
    }

    public function showFile($file)
    {
        $storagePath = $this->getFilePath($file);
        // Ruta al archivo en el storage
        if (Storage::disk($storagePath)->exists($file)) {
            $path = Storage::disk($storagePath)->path($file);
            var_dump($file);

            unset($storagePath);
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mimeTypes = FileHelper::allowedMimetypesByExtension();

            // Verificar si la extensión está soportada
            if (!array_key_exists($extension, $mimeTypes)) {
                abort(403, 'Tipo de archivo no soportado');
            }
            
          return ['file' => $path,'mimeType' => $mimeTypes[$extension]];
        }
    }

    private function getFileDate($file)
    {
        $fullPath = Storage::disk('uploads')->path($file);
        $timestamp = filemtime($fullPath);
        $fecha = Carbon::createFromTimestamp($timestamp);
        return $fecha->format('d-m-Y');       
    }

    public function listFiles()
    {
        $fileList = Storage::disk('uploads')->allFiles('');
        $files = [];
        foreach ($fileList as $file) {
            $ext = $this->getExtensionFileFromString($file);
            $files[] = [
                'name' => basename($file),
                'size' => Storage::disk('uploads')->size($file),
                'date' => $this->getFileDate($file),
                'ext' => $this->getExtensionFileFromString($file),
            ];
        }

        return $files;
    }

    public function deleteFile($fileName)
    {
        $file = basename($fileName);
        $file = urldecode($file);
        $storagePath = $this->getFilePath($file);
        if (Storage::disk($storagePath)->exists($file) && Storage::disk($storagePath)->delete($file)) {
            return [
                'success' => true,
                'message' => "Archivo {$fileName} eliminado correctamente."
            ];
        }
        return [
            'success' => false,
            'message' => "Error al eliminar el archivo {$fileName}."
        ];
    }
}