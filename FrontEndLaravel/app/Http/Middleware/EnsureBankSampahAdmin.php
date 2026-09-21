<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBankSampahAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin_bank_sampah' || !$user->bank_sampah_id) {
            abort(403, 'Akses hanya tersedia untuk admin bank sampah yang terhubung ke bank sampah.');
        }

        return $next($request);
    }
}
