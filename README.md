# ClienteTPV
Ejemplo cliente tpv

## Clonar el proyecto

``` 
    1. git clone  
```

## Middleware Cors
Este middleware es necesario para poder solicitar recursos fuera del dominio.

1. Crear el middleware.
    ```
    php artisan make:middleware Cors
    ```

2. Editar en ```app/Http/Middleware/Cors.php```.
    ```
    public function handle($request, Closure $next)
    {
        return $next($request)
        ->header('Access-Control-Allow-Origin', "*")
        ->header('Access-Control-Allow-Methods', "GET,POST, PUT, DELETE, OPTIONS")
        ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");
    }
    ```

3. Añadir la línea el middleware en ```app/Http/Kernel.php```.
    ```
    protected $middleware = [
            ...
            \App\Http\Middleware\Cors::class,
            ...
        ];
    ```
## Controlador
Para recibir la respuesta de la API es necesario un endpoint de tipo ``` GET```. Se puede crear un controlador nuevo o usar uno existente.

**Ejemplo código del controlador:**
```
public function recibirRespuesta(Request $request)
    {
        $cod = $request->input('cod');
        $msg = $request->input('msg');
        $status = $request->input('status');

        // Lógica de vuestra aplicación para tratar la respuesta

        return view("respuesta")
            ->with('cod', $cod)
            ->with('msg', $msg)
            ->with('status', $status);
    }
```
**Ejemplo código de /routes/web.php:**
```
Route::get('/respuesta', 'TPVController@recibirRespuesta')->name('respuesta');
```

Código de ejemplo en ```app/HTTP/Controllers/TPVController.php```.

## Llamada a la API
La llamada a la API se realiza mediante una petición ```POST``` a la url ```http://localhost:8000/api/sendPayment```.

**NOTA:** *La IP y puerto pueden cambiar dependiendo de la máquina en la que se encuntre la aplicación.*

El cuerpo de la petición debe contener:

```
{
	"user" : "gx@alu.ua.es",                            (X = Número de vuestro grupo)
	"password" : "gx",                                  (X = Número de vuestro grupo)
	"quantity" : "5",                                   (Cantidad del pago)
	"concept" : "Reserva pista de tenis",               (Concepto del pago)
	"urlRedirect" : "http://localhost:8001/respuesta"   (URL para recibir la respuesta)
}
```

La petición se puede realizar mediante un formulario ```POST``` o ```AJAX```, código de ejemplo en ```/resources/views/pago```.

## Códigos de respuesta
La respuesta de la API contiene 3 parámetos: cod, msg, status.
 - **cod:** Código de respuesta
 - **msg:** Estado del pago (éxito) o Mensaje de error (error)
 - **reason:** Razón del estado (solo en caso de éxito)

 A continuación se detallan todas las combinaciones de mensajes.

 - Pago creado con éxito:
    ```
        cod: 200
        msg: Aceptado
        reason: Ok
    ```
 - Pago rechazado porque la tarjeta no tiene saldo suficiente:
    ```
        cod: 200
        msg: Rechazado
        reason: Saldo insuficiente
    ```
    * Se puede provocar introduciendo una tajeta acabada en 0.<br/><br/>
 - Pago rechazado porque la tarjeta no se ha aceptado:
    ```
        cod: 200
        msg: Rechazado
        reason: Tarjeta no aceptada
    ```
    * Se puede provocar introduciendo una tajeta acabada en 1.<br/><br/>
 - Pago rechazado porque la tarjeta ha caducado:
    ```
        cod: 200
        msg: Rechazado
        reason: Tarjeta caducada
    ```
    * Se puede provocar introduciendo una tajeta con fecha de caducidad previa a la fecha actual.<br/><br/>

 - Petición mal formulada:
    ```
        cod: 400
        msg: Error en la petición de pago
    ```
    * La petición no tiene todos los parámetros o no són del tipo correcto. 
    ```
        "user" : "gx@alu.ua.es",                            (X = Número de vuestro grupo)
        "password" : "gx",                                  (X = Número de vuestro grupo)
        "quantity" : "5",                                   (Entero o decimal utilizando separador '.')
        "concept" : "Reserva pista de tenis",               (String)
        "urlRedirect" : "http://localhost:8001/respuesta"   (URL empezando por http::// o https://)
    ```
    **NOTA:** Si el campo urlRedirect es incorrecto la respuesta no se mandará correctamente a la url. 
    Se puede ver el error en 'Herramientas para desarrolladores' (F12 Chrome) en el apartado 'Network' si se ha enviado mediante formulario o 'Console' para AJAX.<br/><br/>



 - Credenciales inválidas:
    ```
        cod: 401
        msg: Credenciales inválidas
    ```  

 - Error del servidor:
    ```
        cod: 500
        msg: Internal Server Error
    ```  

