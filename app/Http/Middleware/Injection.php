<?php

namespace App\Http\Middleware;

use Closure;

class Injection
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
        if(strlen($request->route('slug')) > 225){
            return redirect('/');
        }
        if (!$request->isMethod('post')) {  
            foreach($request->all() as $key => $row){ 
                switch ($key) {
                    case 'page':                   
                        break;
                    case 'search':                    
                        break;
                    case ' ':
                        break; 
                    case '':
                        break;
                    default:
                        if (strlen($row) > 500) {
                            return redirect('/');
                        }
                        break;
                }
            }
        }
        return $next($request);
    }
}
