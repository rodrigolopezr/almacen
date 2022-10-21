<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\categoria;

class categoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            ["Nombre" => "Televisor", "Utilidad" => 35],
            ["Nombre" => "Laptops", "Utilidad" => 40],
            ["Nombre" => "Zapatos", "Utilidad" => 30]
        ];

        categoria::insert($categorias);
    }
}
