<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CleanProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que la ruta obsoleta /dashboard ya no exista (debe dar error 404).
     */
    public function test_obsolete_dashboard_route_returns_404(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(404);
    }

    /**
     * Verifica que un visitante anónimo (guest) no pueda entrar a Mi Cuenta
     * y sea redirigido automáticamente al formulario de inicio de sesión.
     */
    public function test_guest_is_redirected_from_my_account_to_login(): void
    {
        $response = $this->get('/mi-cuenta');

        $response->assertRedirect('/login');
    }

    /**
     * Verifica que un usuario registrado y autenticado pueda acceder sin problemas
     * al panel de cliente "Mi Cuenta" (/mi-cuenta).
     */
    public function test_authenticated_user_can_access_my_account(): void
    {
        // Creamos un usuario de prueba en la base de datos temporal
        $user = User::factory()->create();

        // Accedemos a la ruta simulando que estamos autenticados con ese usuario
        $response = $this->actingAs($user)->get('/mi-cuenta');

        // Comprobamos que carga con éxito (código de estado HTTP 200 OK)
        $response->assertStatus(200);
        $response->assertSee('Mi Cuenta');
        $response->assertSee($user->name);
    }

    /**
     * Verifica que el catálogo de la tienda pública (/tienda) cargue correctamente
     * y esté disponible para cualquier visitante.
     */
    public function test_store_catalog_loads_successfully(): void
    {
        $response = $this->get('/tienda');

        $response->assertStatus(200);
        $response->assertSee('Elegancia Atemporal');
    }
}
