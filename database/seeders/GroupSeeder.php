<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'id' => 1
                , 'educational_experience_id' => 2
                ,'teacher_id' => 8
                , 'name' => 'INTRO A LA PROG 2024'
                , 'shift' => 'Vespertino'
                , 'period' => '2021-2022'
            ],
            [
                'id' => 2
                , 'educational_experience_id' => 1
                ,'teacher_id' => 7
                , 'name' => 'REDES 2025'
                , 'shift' => 'Matutino'
                , 'period' => '2024-2025'
            ],
            [
                'id' => 3
                , 'educational_experience_id' => 7
                ,'teacher_id' => 5
                , 'name' => 'BASE DE DATOS 2023'
                , 'shift' => 'Vespertino'
                , 'period' => '2023-2024'
            ],
            [
                'id' => 4
                , 'educational_experience_id' => 10
                ,'teacher_id' => 5
                , 'name' => 'Principios Diseño 2024'
                , 'shift' => 'Vespertino'
                , 'period' => '2023-2024'
            ],
            [
                'id' => 5
                , 'educational_experience_id' => 6
                ,'teacher_id' => 6
                , 'name' => 'PDS 2024'
                , 'shift' => 'Vespertino'
                , 'period' => '2024-2025'
            ],
            [
                'id' => 6
                , 'educational_experience_id' => 1
                ,'teacher_id' => 7
                , 'name' => 'REDES 2024'
                , 'shift' => 'Matutino'
                , 'period' => '2023-2024'
            ],
        ]);
    }
}
