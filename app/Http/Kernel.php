protected $routeMiddleware = [
    // Other middleware
    'admin' => \App\Http\Middleware\EnsureAdmin::class,
];
