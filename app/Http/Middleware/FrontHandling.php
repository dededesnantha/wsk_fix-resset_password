<?php

namespace App\Http\Middleware;

use Closure;

class FrontHandling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data_ex = explode('/',$request->route()->getPath());
        foreach ($data_ex as $key) {
            if ($key == 'public' || $key == 'index.php') {
            $data_replace = ['public/','index.php/','public','index.php'];
            $new_url = str_replace($data_replace,'', $request->route()->getPath());
            header("Location:".$new_url);
            }
        }
        return $next($request);
    }
}
