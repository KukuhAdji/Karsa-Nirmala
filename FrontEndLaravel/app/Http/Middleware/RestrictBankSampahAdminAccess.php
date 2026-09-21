<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictBankSampahAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user
            && $user->role === 'admin_bank_sampah'
        ) {
            if (!$user->bank_sampah_id) {
                abort(403, 'Akun admin bank sampah belum terhubung ke bank sampah.');
            }

            if (!$request->routeIs([
                'admin.bank-sampah.*',
                'chatbot',
                'logout',
            ])) {
                abort(403, 'Admin bank sampah hanya dapat mengakses kelola bank sampah, kelola marketplace, chatbot, dan logout.');
            }
        }

        return $next($request);
    }
}
