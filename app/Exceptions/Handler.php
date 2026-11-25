<?php

namespace App\Exceptions;

use Admark\Tracking\Http\Repositories\TsourceRepository;
use Admark\Tracking\Http\Services\ConfigService;
use Admark\Tracking\Http\Services\TsourceService;
use Admark\Tracking\Http\Services\ViewService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];


    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $sources = app(config('tracking.driver') === 'database' ? TsourceRepository::class : TsourceService::class);
            $source = $request->query('tsource');
            $phone = $sources->getPhone($source);

            return response()->view('tracking::errors.404', [
                'tsource' => $sources->getTrackingSource($source),
                'id_version' => app(ViewService::class)->getVersion($request->query('id_version')),
                'batch_suffix' => $sources->getBatchSuffix($source),
                'phone' => $phone,
                'phone_formatted' => formatPhone($phone, app(ConfigService::class)->getViewPhoneFormat()),
                'provider' => $sources->getProviderName($source),
            ], 404);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
