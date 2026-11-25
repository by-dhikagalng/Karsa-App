<?php

use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan alias middleware role -> EnsureRole
        $middleware->alias([
            'role' => EnsureRole::class,
        ]);

        // jika tamu mengakses halaman auth, arahkan ke halaman login
        $middleware->redirectGuestsTo(fn () => route('login'));

        // jika user admin yang sudah login membuka login lagi, arahkan ke dashboard admin
        $middleware->redirectUsersTo(fn () => route('admin.events.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
