<?php

namespace Dashed\LaravelLocalization\Middleware;


class LaravelLocalizationMiddlewareBase
{
    /**
     * The URIs that should not be localized.
     *
     * @var array
     */
    protected $except;

    /**
     * Determine if the request has a URI that should not be localized.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldIgnore($request)
    {
        if (in_array($request->method(), config('laravellocalization.httpMethodsIgnored'))) {
            return true;
        }
        $this->except = $this->except ?? config('laravellocalization.urlsIgnored', []);
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
