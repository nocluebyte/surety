<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;

class EncryptUrlParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $parameters = $request->route()->parameters();

        foreach ($parameters as $key => $value) {
            try {
                $decrypted = Crypt::decryptString($value);
                $request->route()->setParameter($key, $decrypted);
            } catch (\Exception $e) {
                abort(404);
            }
        }

        $url = request()->fullUrl();
        parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);

        $decryptedParams = [];
        foreach ($queryParams as $key => $encryptedValue) {
            try {
                $decryptedParams[$key] = Crypt::decryptString($encryptedValue);
            } catch (\Exception $e) {
                dd($e);
                abort(404);
            }
        }

        // foreach ($requestParameter as $key => $value) {
            // try {
            //     $decrypted = Crypt::decryptString($value);
            //     $requestParameter[$key] = $decrypted;
            // } catch (\Exception $e) {
            //     dd($e);
            //     abort(404);
            // }
        // }

        $request->merge($decryptedParams);

        return $next($request);
    }
}
