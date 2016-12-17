<?php
// Routes

//Método que permite imprimir texto en una página.
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//Método que permite obtener una pic mandando su identificador.
$app->get('/pics/obtener/[?id={name}]', function ($request, $response, $args) {

    echo $_GET['id']; //Se despliega el parametro.
    return;

});

//Método que permite obtener una twin mandando su identificador.
$app->get('/twins/obtener/[?id={name}]', function ($request, $response, $args) {

    echo $_GET['id']; //Se despliega el parametro.
    return;

});

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

$app->get('/pic/subir/[{name}]', function ($request, $response, $args) {

    $pic = new Pic; //Se crea un objeto de tipo Pic.

    //Se establecen los valores iniciales para sus atributos.
    $pic->deviceId = "dev1";
    $pic->date = 101216;
    $pic->url = "Mi url 1";
    $pic->longitude = -23;
    $pic->latitude = 70;
    $pic->positive = 0;
    $pic->negative = 0;
    $pic->warning = 0;

    $pic->save(); //Se guarda en la tabla Pic
    $pics = Pic::all();

    return $response->withJson($pics,200,JSON_PRETTY_PINT);

});

$app->get('/json/test', function ($request, $response, $args) {

    $order = Order::first();
    $order->title = "Titulo de la orden";
    $order->save();

    $data = array('name' => 'Rob', 'age' => 40);

    return $response->withJson(Order::first()->toArray());

});
