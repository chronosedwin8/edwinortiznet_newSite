<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\DB;
use App\Core\Session;
use App\Services\Piar\PiarCredits;

/**
 * Acceso de administrador a las herramientas de pago (PIAR con IA y Generador de exámenes), para probarlas.
 *
 * Una cuenta de cliente es de administrador si su correo coincide (sin distinguir mayúsculas) con el de un
 * usuario del panel (admin_users). Es la misma cuenta a la que entra el atajo «Entrar como administrador»
 * (que exige sesión en el panel), así que no hace falta mirar la sesión: basta el correo. Si el usuario del
 * panel se borra, la cuenta deja de ser de administrador.
 *
 * Las cuentas de administrador generan sin plan ni paquete y sin consumir cupo; el modelo y los tokens se
 * siguen registrando y el panel los muestra aparte, marcados como «administrador».
 */
final class AdminAccess
{
    /** @var array<int, bool> customer_id => ¿administrador? (caché por petición) */
    private static array $cache = [];

    /** ¿La cuenta de cliente es la de un administrador del sitio? */
    public static function isAdmin(?int $customerId): bool
    {
        if ($customerId === null || $customerId <= 0) {
            return false;
        }
        if (!array_key_exists($customerId, self::$cache)) {
            self::$cache[$customerId] = DB::value(
                'SELECT 1 FROM customers c JOIN admin_users a ON LOWER(a.email) = LOWER(c.email) WHERE c.id = :id LIMIT 1',
                ['id' => $customerId]
            ) !== null;
        }
        return self::$cache[$customerId];
    }

    /** Condición SQL «la cuenta $column es de un administrador» (para las estadísticas del panel). */
    public static function sql(string $column): string
    {
        return "EXISTS (SELECT 1 FROM customers ac JOIN admin_users aa ON LOWER(aa.email) = LOWER(ac.email) WHERE ac.id = $column)";
    }

    /** Vacía la caché (al empezar cada petición y en las pruebas). */
    public static function reset(): void
    {
        self::$cache = [];
    }

    /** Usuario del panel con sesión iniciada, o null. */
    public static function sessionAdmin(): ?array
    {
        $id = Session::get('admin_id');
        return is_int($id) ? DB::one('SELECT id, email, name FROM admin_users WHERE id = :id', ['id' => $id]) : null;
    }

    /**
     * Atajo «Entrar como administrador»: inicia sesión con la cuenta de cliente del mismo correo del
     * administrador (la crea si no existe) y conserva la sesión del panel. Devuelve el id del cliente.
     * La herramienta acepta antes sus propios términos y perfil.
     */
    public static function enterAsCustomer(array $admin): int
    {
        $customerId = PiarCredits::customerFor(strtolower((string) $admin['email']), (string) $admin['name']);
        Session::regenerate();
        Session::set('admin_id', (int) $admin['id']);
        Session::set('customer_id', $customerId);
        unset(self::$cache[$customerId]);
        return $customerId;
    }
}
