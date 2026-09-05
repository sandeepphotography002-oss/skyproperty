<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Purane subdomain se naye par bhej deta hai.
 *
 * Pehla subdomain "spkyproperty" tha -- "sky" ki jagah "spky" likha
 * gaya. Naam ab "skyproperty" hai, par purana pata poster par chhap
 * chuka hai aur logon ke phone mein hai. Isliye wo mara nahi ja sakta:
 * jo bhi purane par aaye, use usi page par naye pate par bhej dete hain.
 *
 * 301 hai, 302 nahi -- Google ko batana hai ki ye badlaav pakka hai,
 * taaki wo purane pate ki jagah naya yaad rakhe.
 */
class CanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $canonical = trim((string) config('site.canonical_host'));

        if ($canonical === '') {
            return $next($request);
        }

        $host = $request->getHost();

        /* Pehle se sahi jagah par ho, ya localhost par kaam kar rahe ho,
           to kuch nahi karna. */
        if ($host === $canonical || $this->isLocal($host)) {
            return $next($request);
        }

        /* Poora rasta aur query saath le ja rahe hain -- aadmi jis page
           par aaya tha, wahi page naye pate par khulna chahiye. */
        $to = $request->getScheme() . '://' . $canonical . $request->getRequestUri();

        return redirect()->to($to, 301);
    }

    /** Local par redirect nahi karna, warna kaam karna hi mushkil ho jaye. */
    private function isLocal(string $host): bool
    {
        return in_array($host, ['localhost', '127.0.0.1', '::1'], true)
            || str_ends_with($host, '.test')
            || str_ends_with($host, '.local');
    }
}
