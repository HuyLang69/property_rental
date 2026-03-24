<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

Illuminate\Support\Facades\Auth::loginUsingId(1);

$routes = [
    '/dashboard',
    '/dashboard/trips',
    '/host',
    '/host/bookings',
    '/host/earnings',
    '/host/reviews',
    '/host/listings',
    '/admin'
];

foreach ($routes as $uri) {
    try {
        $request = Illuminate\Http\Request::create($uri, 'GET');
        // We need to re-bind the request to the app so url() works correctly inside views
        $app->instance('request', $request);
        $response = $kernel->handle($request);
        echo str_pad($uri, 20) . " => " . $response->status() . "\n";
    } catch (\Throwable $e) {
        echo str_pad($uri, 20) . " => ERROR: " . $e->getMessage() . "\n";
    }
}
