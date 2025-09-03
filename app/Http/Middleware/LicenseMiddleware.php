<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LicenseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $scheme = $request->getScheme(); // http or https
        $host = $request->getHost();
        $port = $request->getPort();

        // Check if the port is the default for the scheme, and exclude it if necessary
        if (($scheme == 'http' && $port == 80) || ($scheme == 'https' && $port == 443)) {
            $url = $scheme . '://' . $host;
        } else {
            $url = $scheme . '://' . $host . ':' . $port;
        }
        $md5Hash = md5($url);
        $freeHash = md5('https://unfee.style');
        if (!Storage::disk('public')->exists('key/' . $freeHash) && !Storage::disk('public')->exists('key/'.$md5Hash)) {
            return redirect('404');
        }
        return $next($request);
    }
}
