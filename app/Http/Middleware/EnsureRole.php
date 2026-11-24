<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Memastikan user sudah login, memiliki role yang diizinkan,
     * dan (untuk admin_ormawa) hanya boleh mengelola event milik organisasinya sendiri.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {   
        $user = $request->user();

        // jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // cek apakah role user termasuk yang diizinkan (admin_ormawa / super_admin)
        if (empty($roles) && !in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        // cek kepemilikan event jika route memiliki parameter {event}
        $eventParam = $request->route('event');

        if ($eventParam !== null && !$user->isSuperAdmin()) {
            $event = $eventParam instanceof Event
            ? $eventParam
            : Event::findOrFail($eventParam);

            if (!$user->canManageEvent($event)) {
                abort(403, 'Anda hanya dapat mengelola event milik organisasi Anda sendiri.');
            }
        }

        return $next($request);
    }
}
