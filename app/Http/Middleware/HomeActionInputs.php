<?php

namespace App\Http\Middleware;

use App\Http\Requests\HomeActionPost;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;

// ParameterBag::class;
class HomeActionInputs
{
    /**
     * Handle an incoming request.
     *
     * @param  App\Http\Requests\HomeActionPost  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->bag($request->request);
        return $next($request);
    }

    public function bag(ParameterBag $bag)
    {

        $bag->replace(collect($bag->all())->map(function ($value, $key) {
            if (is_string($value) && $key != "_method" && $key != "_token") {
                return Str::lower($value);
            }
            return $value;
        })->all());
    }
}
