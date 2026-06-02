<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = [

            [
                'nombre' => '1 Mes',
                'precio' => 19990,
                'meses' => 1,
                'descripcion' => 'Ideal para comenzar a utilizar CicmaHR.',
                'destacado' => false,
            ],

            [
                'nombre' => '3 Meses',
                'precio' => 50990,
                'meses' => 3,
                'descripcion' => 'Ahorra y mantén tu empresa operativa.',
                'destacado' => false,
            ],

            [
                'nombre' => '6 Meses',
                'precio' => 109990,
                'meses' => 6,
                'descripcion' => 'Excelente equilibrio entre costo y estabilidad.',
                'destacado' => false,
            ],

            [
                'nombre' => '1 Año',
                'precio' => 179000,
                'meses' => 12,
                'descripcion' => 'La opción más conveniente para empresas.',
                'destacado' => true,
            ],

        ];

        return view('planes.index', compact('planes'));
    }
}