<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
<<<<<<< HEAD
use Illuminate\Http\Request;
=======
>>>>>>> 1e3d2044a7dad1701ef2926ebff12b3bb07fa61e
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
<<<<<<< HEAD
        $this->renderable(function (Throwable $e, Request $request) {
            if($request->is('api/*')){
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
                500);
            }
=======
        $this->reportable(function (Throwable $e) {
            //
>>>>>>> 1e3d2044a7dad1701ef2926ebff12b3bb07fa61e
        });
    }
}
