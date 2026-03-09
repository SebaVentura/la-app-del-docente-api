<?php

namespace Database\Seeders;

use App\Models\DeclaracionJurada;
use App\Models\Escuela;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeclaracionesJuradasSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::with('escuelas')->get();

        foreach ($users as $user) {
            foreach ($user->escuelas as $escuela) {
                DeclaracionJurada::factory()->create([
                    'user_id' => $user->id,
                    'escuela_id' => $escuela->id,
                ]);
            }
        }
    }
}
