<?php

use Illuminate\Database\Seeder;
use App\MicroController;

class MicrocontrollerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MicroController::create([
            'nombre' => 'root',
            'estado' => 1
        ]);
    }
}
