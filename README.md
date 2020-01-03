# ClienteTPV
Ejemplo cliente tpv

## Crear middleware Cors
Este middleware sireve para poder solicitar recursos fuera del dominio

Crear el middleware
```
php artisan make:middleware Cors
```

Editar en app/Http/Middleware/Cors.php
```
public function handle($request, Closure $next)
{
    return $next($request)
    ->header('Access-Control-Allow-Origin', "*")
    ->header('Access-Control-Allow-Methods', "GET,POST, PUT, DELETE, OPTIONS")
    ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");
}
```
Añadir la línea el middleware en app/Http/Kernel.php
```
protected $middleware = [
        ...
        \App\Http\Middleware\Cors::class,
        ...
    ];
```
