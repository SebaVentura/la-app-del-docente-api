<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create(["password" => bcrypt('secret')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_login_and_retrieve_schools()
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $login->assertStatus(200)->assertJsonStructure(['data' => ['token', 'user']]);

        $token = $login->json('data.token');

        $resp = $this->withHeader('Authorization', 'Bearer '.$token)
                     ->getJson('/api/escuelas');

        $resp->assertStatus(200)->assertJson(['data' => []]);

        // create a school
        $resp2 = $this->withHeader('Authorization', 'Bearer '.$token)
                      ->postJson('/api/escuelas', ['nombre' => 'Primaria 1']);

        $resp2->assertStatus(201)->assertJsonPath('data.nombre', 'Primaria 1');

        $resp3 = $this->withHeader('Authorization', 'Bearer '.$token)
                      ->getJson('/api/escuelas');
        $resp3->assertJsonCount(1, 'data');
    }

    public function test_sync_bootstrap_empty_database()
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);
        $token = $this->postJson('/api/login', ['email'=>$user->email,'password'=>'secret'])
                      ->json('data.token');

        $payload = [
            'profile' => ['nombres' => 'Juan'],
            'schools' => [[ 'id'=>10, 'nombre'=>'Esc A' ]],
            'courses' => [[ 'id'=>20, 'escuelaId'=>10, 'nombre'=>'Curso 1' ]],
            'students' => [[ 'cursoId'=>20, 'apellidos'=>'Perez','nombres'=>'Ana','legajo'=>'123' ]],
            'classes' => [[ 'id'=>30, 'cursoId'=>20, 'fecha'=>'2026-01-01' ]],
            'attendance' => ['2026-01-01' => [20 => [1 => ['estado'=>'present']]]],
            'materials' => [],
            'diagnostics' => [],
            'plans' => [],
        ];

        $resp = $this->withHeader('Authorization', 'Bearer '.$token)
                     ->postJson('/api/sync/bootstrap', $payload);
        $resp->assertStatus(200)->assertJson(['ok' => true]);

        // subsequent call should return dump
        $resp2 = $this->withHeader('Authorization', 'Bearer '.$token)
                      ->postJson('/api/sync/bootstrap', $payload);
        $resp2->assertStatus(200)->assertJsonStructure(['data']);
    }
}
