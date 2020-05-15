<?php

use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->delete();

        $productos = [
            ['id' => 1, 'producto' => 'Producto1_1', 'categoria_id' => 1],
            ['id' => 2, 'producto' => 'Producto1_2', 'categoria_id' => 1],
            ['id' => 3, 'producto' => 'Producto1_3', 'categoria_id' => 1],
            ['id' => 4, 'producto' => 'Producto2_1', 'categoria_id' => 2],
            ['id' => 5, 'producto' => 'Producto2_2', 'categoria_id' => 2],
            ['id' => 6, 'producto' => 'Producto2_3', 'categoria_id' => 2],
            ['id' => 7, 'producto' => 'Producto3_1', 'categoria_id' => 3],
            ['id' => 8, 'producto' => 'Producto3_2', 'categoria_id' => 3],
            ['id' => 9, 'producto' => 'Producto3_3', 'categoria_id' => 3],
        ];

        foreach ($productos as $producto) {
            \App\Productos::create($producto);
        }
    }
}
