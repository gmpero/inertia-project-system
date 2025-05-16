<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_priorities')->insert([
            [
                'name' => 'Низкий',
                'color' => '#10b981',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Средний',
                'color' => '#f59e0b',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Высокий',
                'color' => '#ef4444',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
