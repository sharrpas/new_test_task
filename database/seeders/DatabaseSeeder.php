<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //افزودن دیتا های اولیه
        $user = User::query()->firstOrCreate([
            'name' => "Sina",
            'mobile' => '09184185136',
        ],
            ['password' => bcrypt('1234'),]);

        $role = Role::query()->firstOrCreate([
            'name' => 'admin',
        ]);
        !$user->hasRole($role->name) ? $user->roles()->attach($role->id) : null;

        Role::query()->firstOrCreate([
            'name' => 'user',
        ]);
    }
}
