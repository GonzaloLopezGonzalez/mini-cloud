<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator; // Corrige el namespace
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FileHelper;

class FileController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new File();
    }

    // Página principal y manejo de subida
    public function uploadFiles(Request $request)
    {
        $message = null;
        $type = null;
        if ($request->isMethod('post') && $request->hasFile('files')) {
            $files = $request->file('files');
            $results = $this->model->uploadMultipleFiles($files);

            // Verifica si todos los archivos se subieron correctamente
            $allSuccessful = collect($results)->every('success');

            $message = $allSuccessful ? 'Todos los archivos se subieron correctamente.' : 'Error al realizar la subida.';
            $type = $allSuccessful ? 'success' : 'danger';
        }

        $files = $this->model->listFiles();

        return view('files.uploadfiles');
    }

    public function imageGallery(Request $request)
    {
        $images = $this->model->imageGallery();
         return view('files.imageGallery', compact('images'));
    }

    //Listado de Ficheros
    public function listFiles(Request $request)
    {
        $files = $this->model->listFiles();
        $total = count($files);
     
        $perPage = env('TOTAL_FILES_PER_PAGE'); // Número de ficheros por página
        $currentPage = $request->input('page', 1); // Página actual, por defecto 1
        $offset = ($currentPage - 1) * $perPage;

        // Obtener solo los ficheros de la página actual
        $items = array_slice($files, $offset, $perPage);
        unset($files);
        
        // Crear el paginador
        $paginator = new LengthAwarePaginator(
            $items, // Elementos de la página actual
            $total, // Total de ficheros
            $perPage, // Elementos por página
            $currentPage, // Página actual
            ['path' => $request->url()] // URL base para los enlaces de paginación
        );

         Paginator::useBootstrapFive();
        return view('files.listFiles', compact('paginator'));
    }

    // Subida mediante AJAX
    public function uploadAjax(Request $request)
    {
        if ($request->isMethod('post') && $request->hasFile('files')) {
            $files = $request->file('files');

            $results = $this->model->uploadMultipleFiles($files);
            $allSuccessful = collect($results)->every('success');

            return response()->json([
                'success' => $allSuccessful,
                'message' => $allSuccessful ? 'Todos los archivos se subieron correctamente.' : 'Algunos archivos no se pudieron subir.',
                'details' => $results
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Solicitud inválida o no se enviaron archivos.'
        ]);
    }


    // Descargar archivo
    public function downloadFiles(Request $request)
    {
        if ($request->has('download')) {
            $fileName = $request->query('download');
            $filePath = $this->model->downloadFile($fileName);

            if ($filePath !== false){

                return response()->download($filePath, $fileName, [
                    'Content-Type' => 'application/octet-stream',
                ]);
            }
            unset($fileName,$filePath);

            $message = 'El archivo no existe.';
            $type = 'danger';
            $files = $this->model->listFiles();

            return view('index', compact('files', 'message', 'type'));
        }
    }

    // Eliminar archivo
    public function delete(Request $request)
    {
        if ($request->has('delete')) {
            $fileName = $request->query('delete');
            $result = $this->model->deleteFile($fileName);
            unset($fileName);

            $message = $result['message'];
            $type = $result['success'] ? 'success' : 'danger';
            unset($result);
            
            $files = $this->model->listFiles();

            return redirect()->route('files.list');
        }
    }

    // Validar token CSRF (Laravel lo maneja automáticamente, pero puedes personalizarlo)
    private function verifyCsrfToken($token)
    {
        // Laravel maneja CSRF automáticamente en formularios y peticiones.
        // Si necesitas validación adicional, implementa aquí la lógica.
        return true;
    }

    public function showFile(Request $request)
    {
        $file = $request->query('filename');
        $data = $this->model->showFile($file);

        // Limpiar completamente el buffer de salida
        ob_end_clean();

        return response()->file($data['file'], ['Content-Type' => $data['mimeType']]);
    }
}