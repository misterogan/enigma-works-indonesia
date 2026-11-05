<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Domain company profile hanya menayangkan halaman utama.
 * Path lain (/layanan, /blog, /admin, ...) dialihkan permanen ke website Enigma Health
 * agar tidak muncul sebagai konten ganda.
 */
class CompanyDomainGuard
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = config('company.domain');

        // www.enigmaworks.web.id → https://enigmaworks.web.id/ (rute www di routes/web.php menangkap semua path)
        if ($request->getHost() === 'www.'.$domain) {
            return redirect()->away('https://'.$domain.'/', 301);
        }

        if ($request->getHost() === $domain && $request->path() !== '/') {
            $query = $request->getQueryString();

            return redirect()->away(config('company.main_url').'/'.$request->path().($query ? '?'.$query : ''), 301);
        }

        return $next($request);
    }
}
