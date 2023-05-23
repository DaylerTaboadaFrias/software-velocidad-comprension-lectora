<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Role;
use App\Enums\Removed;
use App\Enums\Working;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Prueba',
            'role' => Role::Admin,
            'working' => Working::No,
            'password' => Hash::make('12345678'),
            'email' => 'prueba@gmail.com',
            'email_verified_at' => now(),  
        ]);


        \App\Models\Plan::factory()->create([
            'name' => 'Basic',
            'cost' => 9.99,
            'amount_days' => 30,
            'type' => Role::Cliente,
            'removed' => Removed::Activado
        ]);
        \App\Models\Plan::factory()->create([
            'name' => 'Premium',
            'cost' => 19.99,
            'amount_days' => 30,
            'type' => Role::Cliente,
            'removed' => Removed::Activado
        ]);

        \App\Models\Benefit::factory()->create([
            'description' => 'Acceso al registro de eventos',
            'plan_id' => 1,
            'permiso' => 'Habilitado',
            'removed' => Removed::Activado
        ]);


        \App\Models\Benefit::factory()->create([
            'description' => 'Envia ofertas a fotografos',
            'plan_id' => 1,
            'permiso' => 'Deshabilitado',
            'removed' => Removed::Activado
        ]);

        \App\Models\Benefit::factory()->create([
            'description' => 'Asistencia con I.A hacia tus clientes',
            'plan_id' => 1,
            'permiso' => 'Deshabilitado',
            'removed' => Removed::Activado
        ]);


        \App\Models\Benefit::factory()->create([
            'description' => 'Acceso al registro de eventos',
            'plan_id' => 2,
            'permiso' => 'Habilitado',
            'removed' => Removed::Activado
        ]);
        \App\Models\Benefit::factory()->create([
            'description' => 'Envia oferta a fotografos',
            'plan_id' => 2,
            'permiso' => 'Habilitado',
            'removed' => Removed::Activado
        ]);

        \App\Models\Benefit::factory()->create([
            'description' => 'Asistencia con I.A hacia tus clientes',
            'plan_id' => 2,
            'permiso' => 'Habilitado',
            'removed' => Removed::Activado
        ]);
    }
}
