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
$app->get('/json/obtener/pic/[?id={id}]', function ($request, $response, $args) {

    $idPic = $_GET['id']; //Se obtiene el identificador de la Pic.
    $pic = Pic::where('id','=',$idPic)->get(); //Busca todas las fotos del dispositivo.

    return $response->withJson($pic,200,JSON_PRETTY_PRINT);

});

//Método que permite obtener una twin mandando su identificador.
$app->get('/json/obtener/twin/[?id={id}]', function ($request, $response, $args) {

    $idTwin = $_GET['id']; //Se obtiene el identificador de la Pic.
    $pic = Twin::where('id','=',$idTwin)->get(); //Busca todas las fotos del dispositivo.

    return $response->withJson($pic,200,JSON_PRETTY_PRINT);

});

//Método que permite obtener todas las pics de la base de datos.
$app->get('/json/obtener/piclist', function ($request, $response, $args) {

    $pic = Pic::select()->get();

    return $response->withJson($pic,200,JSON_PRETTY_PRINT);

});

//Método que permite obtener todas las twins de la base de datos.
$app->get('/json/obtener/twinlist', function ($request, $response, $args) {

    $pic = Twin::select()->get();

    return $response->withJson($pic,200,JSON_PRETTY_PRINT);

});

//Método que permite obtener todas las Twins asociada a un dispositivo.
$app->get('/json/obtener/twin/twinlist/[?devid={devid}]', function ($request, $response, $args) {

    $idDev = $_GET['devid']; //Se obtiene el identificador del dispositivo.
    $twins = Twin::join('pics','idLocal','=','pics.id')->where('pics.deviceId','=',$idDev)->get();
    return $response->withJson($twins,200,JSON_PRETTY_PRINT);

});

//Método que sube una Pic para cierto dispositivo.
$app->get('/pics/subir/[?id={name}]', function ($request, $response, $args) {

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

    $fecha = $pic->date;

    $pic2 = Pic::where('deviceId','=',$idDev)->where('date','=',$fecha)->get(); //Busca todas las fotos para el dispositivo en tal fecha.
    return $response->withJson($pic2,200,JSON_PRETTY_PRINT);

});

//Método que sube una Twin.
$app->get('/twins/subir/[?info={name}]', function ($request, $response, $args) {

    $datos = $_GET["info"];
    $token = strtok($datos,",");

    $idPicLocal = $token; //Foto del usuario local.
    $token = strtok(",");
    $idPicRemote = $token; //Foto del usuario remoto.

    $twin = new Twin;
    $twin->idLocal = $idPicLocal; //Se asocia la foto tomada desde mi celular.
    $twin->idRemote = $idPicRemote; //Se asocia con la foto remota.
    $twin->save(); //Se guarda en la tabla Twin.

    $twin2 = Twin::where('idLocal','=',$idPicLocal);
    return;

});

//Método que permite darle un like a una Pic.
$app->get('/pics/like/[?id={name}]', function ($request, $response, $args) {

    $idPic = $_GET["id"]; //Se obtiene el identificador de la Pic.
    $pic = Pic::where('id','=',$idPic)->first();
    $cantLikes = ($pic->positive) + 1;
    $pic->positive = $cantLikes;
    $pic->save();
    return;

});

//Método que permite darle un dislike a una Pic.
$app->get('/pics/dislike/[?id={name}]', function ($request, $response, $args) {

    $idPic = $_GET["id"]; //Se obtiene el identificador de la Pic.
    $pic = Pic::where('id','=',$idPic)->first();
    $cantDislikes = ($pic->negative) + 1;
    $pic->negative = $cantDislikes;
    $pic->save();
    return;

});

//Método que permite darle un warning a una Pic.
$app->get('/pics/warning/[?id={name}]', function ($request, $response, $args) {

    $idPic = $_GET["id"]; //Se obtiene el identificador de la Pic.
    $pic = Pic::where('id','=',$idPic)->first();
    $cantWarnings = ($pic->warning) + 1;
    $pic->warning = $cantWarnings;
    $pic->save();
    return;

});

//Método que permite obtener un twin.
$app->get('/test', function ($request, $response, $args) {

    $twin = Twin::where('id','=','1')->first();
    return $response->withJson($twin,200,JSON_PRETTY_PRINT);;

});

