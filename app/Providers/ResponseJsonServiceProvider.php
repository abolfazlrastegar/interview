<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseJsonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($message = null, $data = null) {
            if ($message != null || $data != null) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
            return response()->json([
                'status' => true
            ], 200);
        });

        Response::macro('validation', function ($message, $code) {
            return response()->json([
                'status' => 'validation',
                'message' => $message
            ], $code);
        });

        Response::macro('error', function ($message, $code = 500) {
            return response()->json([
                'status' => 'error',
                'message' => $message
            ], $code);
        });
    }
}
