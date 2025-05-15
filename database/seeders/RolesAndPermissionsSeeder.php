<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Очистка кеша разрешений
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Проекты
        Permission::firstOrCreate(['name' => 'create projects']);
        Permission::firstOrCreate(['name' => 'view projects']);
        Permission::firstOrCreate(['name' => 'edit projects']);
        Permission::firstOrCreate(['name' => 'delete projects']);
//        Permission::firstOrCreate(['name' => 'manage project members']);

        // Задачи
        Permission::firstOrCreate(['name' => 'create tasks']);
        Permission::firstOrCreate(['name' => 'view tasks']);
        Permission::firstOrCreate(['name' => 'edit tasks']);
        Permission::firstOrCreate(['name' => 'delete tasks']);
        Permission::firstOrCreate(['name' => 'assign tasks']);
        Permission::firstOrCreate(['name' => 'change task status']);

        // Сообщения
        Permission::firstOrCreate(['name' => 'create messages']);
        Permission::firstOrCreate(['name' => 'view messages']);
        Permission::firstOrCreate(['name' => 'edit messages']);
        Permission::firstOrCreate(['name' => 'delete messages']);
        Permission::firstOrCreate(['name' => 'delete any messages']);

        // 3. Создание ролей
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // 4. Назначение прав (можно вынести в отдельный сидер)
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo([
            'view projects',
            'edit projects',
            'create tasks',
        ]);

// Назначение прав обычному пользователю
        $user->givePermissionTo([
            'view projects',
            'view tasks',
            'create messages'
        ]);

        // 5. Тестовый админ (только для разработки!)
        if (app()->environment('local')) {
            User::firstOrCreate(
                ['email' => 'admin@mail.ru'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('111111')
                ]
            )->assignRole('admin');
            User::firstOrCreate(
                ['email' => 'manager@mail.ru'],
                [
                    'name' => 'Manager',
                    'password' => bcrypt('111111')
                ]
            )->assignRole('manager');
            User::firstOrCreate(
                ['email' => 'user@mail.ru'],
                [
                    'name' => 'User',
                    'password' => bcrypt('111111')
                ]
            )->assignRole('user');
        }
    }
}
