<?php

namespace Database\Seeders;

use App\Models\PerfilDocente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin Docente',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        $teacher = User::updateOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'name' => 'Docente Titular',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        $assistant = User::updateOrCreate(
            ['email' => 'colega@test.com'],
            [
                'name' => 'Docente Suplente',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        // User intentionally left without domain data for empty-state endpoint checks.
        User::updateOrCreate(
            ['email' => 'empty@test.com'],
            [
                'name' => 'Usuario Vacio',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        $this->seedProfile($admin, [
            'nombres' => 'Ana',
            'apellidos' => 'Gomez',
            'dni' => '28123456',
            'cuil' => '27-28123456-2',
            'domicilio' => 'Av. Siempre Viva 742',
            'localidad' => 'La Plata',
            'provincia' => 'Buenos Aires',
            'telefono' => '+54 221 555-0101',
        ]);

        $this->seedProfile($teacher, [
            'nombres' => 'Bruno',
            'apellidos' => 'Lopez',
            'dni' => '30999888',
            'cuil' => '20-30999888-5',
            'domicilio' => 'Calle 12 N 145',
            'localidad' => 'Mar del Plata',
            'provincia' => 'Buenos Aires',
            'telefono' => '+54 223 555-0102',
        ]);

        $this->seedProfile($assistant, [
            'nombres' => 'Carla',
            'apellidos' => 'Diaz',
            'dni' => null,
            'cuil' => null,
            'domicilio' => null,
            'localidad' => 'Rosario',
            'provincia' => 'Santa Fe',
            'telefono' => null,
        ]);
    }

    private function seedProfile(User $user, array $data): void
    {
        PerfilDocente::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );
    }
}
