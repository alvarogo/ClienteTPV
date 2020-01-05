# ClienteTPV
Ejemplo cliente tpv

## Clonar el proyecto del cliente

``` 
    01. Abrir un terminal para clonar el proyecto
    02. Ejecutar git clone https://github.com/alvarogo/ClienteTPV.git
    03. Iniciar Xampp (Apache y MySQL).
    04. Abrir phpMyAdmin (Botón Admin de Xampp en MySQL).
    05. Crear base de datos llamada 'tpv_cliente' codificación 'utf8_bin'. 
    06. Abrir terminal en la ubicación del proyecto.
    07. Ejecutar composer update --no-scripts (Para obtener el vendor)
    08. Copiar el archivo '.env.example' como '.env'. (Cambiar la configuración de acceso a mysql si no usais la configuración por defecto).
    09. Ejecutar composer dump-autoload
    10. Ejecutar php artisan migrate:install
    11. Ejecutar php artisan migrate
    12. Ejecutar php artisan key:generate
    13. Ejecutar php artisan serve --port=8001 (Puede se otro puerto pero el código de ejemplo está preparado para este)
    14. Abrir en el navegador http://localhost:8001/
```

## Clonar el proyecto del api
``` 
<<<<<<< HEAD
    01. Descargar la release https://github.com/m3cruz/TPV_Virtual_IW/releases/tag/v0.2
=======
    01. Descargar la release https://github.com/m3cruz/TPV_Virtual_IW/releases/tag/v0.1
>>>>>>> c30556461c1e2c1ec64b5c74f011137461374e45
    02. Descomprimir la release
    03. Iniciar Xampp (Apache y MySQL).
    04. Abrir phpMyAdmin (Botón Admin de Xampp en MySQL).
    05. Crear base de datos llamada 'tpv_virtual' codificación 'utf8_spanish_ci'. 
    06. Abrir terminal en la ubicación del proyecto.
    07. Ejecutar composer update --no-scripts (Para obtener el vendor)
    08. Copiar el archivo '.env.example' como '.env'. (Cambiar la configuración de acceso a mysql si no usais la configuración por defecto).
    09. Ejecutar composer dump-autoload
    10. Ejecutar php artisan migrate:install
    11. Ejecutar php artisan key:generate
    12. Ejecutar php artisan migrate --seed
    13. Ejecutar php artisan serve --port=8000 (Puede se otro puerto pero el código de ejemplo está preparado para este)
    14. Abrir en el navegador http://localhost:8000/payments
```

**NOTA:** Para probar el API con los dos proyectos de ejemplo se deben usar los puertos 8000 para el API y 8001 para el cliente porque las llamadas se hacen con esos puertos. A la hora de probar la API usando vuestra aplicación podéis usar el puerto que queráis.

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
        cod: 402
        msg: Rechazado
        reason: Saldo insuficiente
    ```
    * Se puede provocar introduciendo una tajeta acabada en 0.<br/><br/>
 - Pago rechazado porque la tarjeta no se ha aceptado:
    ```
        cod: 402
        msg: Rechazado
        reason: Tarjeta no aceptada
    ```
    * Se puede provocar introduciendo una tajeta acabada en 1.<br/><br/>
 - Pago rechazado porque la tarjeta ha caducado:
    ```
        cod: 402
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

