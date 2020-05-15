<?php

use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->delete();

        $categorias = [
            ['id' => 1, 'categoria' => 'Categoria1'],
            ['id' => 2, 'categoria' => 'Categoria2'],
            ['id' => 3, 'categoria' => 'Categoria3']
        ];

        foreach ($categorias as $categoria) {
            \App\Categorias::create($categoria);
        }
    }
}
