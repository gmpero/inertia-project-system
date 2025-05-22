<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Новая', 'color' => '#3b82f6', 'is_default' => true]);
        Status::create(['name' => 'В работе', 'color' => '#f59e0b']);
        Status::create(['name' => 'На проверке', 'color' => '#8b5cf6']);
        Status::create(['name' => 'Завершена', 'color' => '#10b981']);
    }
}
