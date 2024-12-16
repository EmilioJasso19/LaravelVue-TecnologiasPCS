<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enrollments')->insert([
            [
                'id' => 1,
                'student_id' => 11,
                'group_id' => 2
            ],
            [
                'id' => 2,
                'student_id' => 12,
                'group_id' => 1
            ],
            [
                'id' => 3,
                'student_id' => 13,
                'group_id' => 2
            ],
            [
                'id' => 4,
                'student_id' => 14,
                'group_id' => 1
            ],
            [
                'id' => 5,
                'student_id' => 15,
                'group_id' => 1
            ],
            [
                'id' => 6,
                'student_id' => 16,
                'group_id' => 1
            ],
            [
                'id' => 7,
                'student_id' => 17,
                'group_id' => 1
            ],
            [
                'id' => 8,
                'student_id' => 18,
                'group_id' => 1
            ],
        ]);
    }
}
