<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator; // Corrige el namespace
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LinkController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Link();
    }

    public function createLink()
    {
        return view('links.newlink');
    }

    public function saveLink(Request $request)
    {
         $request->validate([
            'nombre' => 'required|string|max:255',
            'enlace' => 'required|url',
        ]);
        $linksBD = Link::create([
            'nombre' => $request->input('nombre'),
            'enlace' => $request->input('enlace'),
        ]);

        return redirect()->route('links.list');
    }

    public function deleteLink(Request $request)
    {
        $link = Link::find($request->query('id'));
        if ($link) {
            $link->delete();
            return redirect()->route('links.list');
        }
    }
    public function listLinks(Request $request)
    {
        $linksBD = Link::orderBy('nombre', 'asc')->get();
        $links = $linksBD->toArray();
        $total = count($links);

        $perPage = env('TOTAL_FILES_PER_PAGE'); // Número de ficheros por página
        $currentPage = $request->input('page', 1); // Página actual, por defecto 1
        $offset = ($currentPage - 1) * $perPage;

        // Obtener solo los ficheros de la página actual
        $items = array_slice($links, $offset, $perPage);
        unset($links);

        // Crear el paginador
        $paginator = new LengthAwarePaginator(
            $items, // Elementos de la página actual
            $total, // Total de ficheros
            $perPage, // Elementos por página
            $currentPage, // Página actual
            ['path' => $request->url()] // URL base para los enlaces de paginación
        );

         Paginator::useBootstrapFive();

        return view('links.listlinks', compact('paginator'));
    }

}