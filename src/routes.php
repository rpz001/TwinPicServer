<?php
// Routes

//Clase que representa una Pic.
class Pic extends Illuminate\Database\Eloquent\Model {

    //Se especifica la tabla donde se guardan las pics.
    protected $table = 'pics';

    //Se suprime las fechas para no agregar a la tabla.
    public $timestamps = false;

    //Se especifica los atributos de la clase en un arreglo.
    protected $fillable = ['deviceId','date','url','latitude','longitude','positive','negative','warning'];

}

//Clase que representa una Twin
class Twin extends Illuminate\Database\Eloquent\Model {

    //Se especifica la tabla donde se guardan las pics.
    protected $table = 'twins';

    //Se suprime las fechas para no agregar a la tabla.
    public $timestamps = false;

    //Se especifica los atributos de la clase en un arreglo.
    protected $fillable = ['id','idLocal','idRemote'];

}

//Método que permite obtener una pic mandando su identificador.
$app->get('/pics/obtener/[?id={name}]', function ($request, $response, $args) {

    $idDev = $_GET['id']; //Se obtiene el identificador del dispositivo.
    $pic = Pic::find($idDev); //Busca todas las fotos del dispositivo.

    return $response->withJson($pic,200,JSON_PRETTY_PINT);

});



//Método que permite obtener una twin mandando su identificador.
$app->get('/twins/obtener/[?id={name}]', function ($request, $response, $args) {

    //$idDev = $_GET['id']; //Se obtiene el identificador del dispositivo.
    //$pic = Twin::find($idDev); //Busca todas las fotos del dispositivo.
    //return $response->withJson($pic,200,JSON_PRETTY_PINT);
    return;

});

//Método que prueba la subida de una Pic para cierto dispositivo.
$app->get('/test/pic/subir/[?id={name}]', function ($request, $response, $args) {

    $idDev = $_GET["id"]; //Se obtiene el identificador del dispositivo.
    $pic = new Pic; //Se crea un objeto de tipo Pic.

    $pic->deviceId = $idDev; //El id del celular.
    $pic->date = date('c'); //Fecha que se tomo la foto.
    $pic->url = "Esta es una prueba"; //Url donde se aloja la foto
    $pic->longitude = -23.123; //Posición en longitud del planeta.
    $pic->latitude = -70.343; //Posición en latitud del planeta.
    $pic->positive = 0; //Cantidad de likes.
    $pic->negative = 0; //Cantidad de dislikes.
    $pic->warning = 0; //Cantidad de advertencias.
    $pic->save(); //Se guarda en la tabla Pic

    $pic2 = Pic::find($idDev); //Busca todas las fotos para el dispositivo.
    return $response->withJson($pic2,200,JSON_PRETTY_PINT);

});

//Método que prueba la subida de una Pic para cierto dispositivo.
$app->get('/test/twin/subir/[{name}]', function ($request, $response, $args) {

    //Por implementar.

    return;

});

//Método que permite imprimir texto en una página.
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);

});

$app->get('/json/test', function ($request, $response, $args) {

    $order = Order::first();
    $order->title = "Titulo de la orden";
    $order->save();

    $data = array('name' => 'Rob', 'age' => 40);

    return $response->withJson(Order::first()->toArray());

});
