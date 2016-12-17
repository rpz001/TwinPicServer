<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


class Order extends Illuminate\Database\Eloquent\Model {

    protected $fillable = ['title'];
    public $timestamps = false;
}

//Clase que representa una Pic.
class Pic extends Illuminate\Database\Eloquent\Model {

    //Se especifica la tabla donde se guardan las pics.
    protected $table = 'pics';

    //Se suprime las fechas para no agregar a las tabla.
    public $timestamps = false;

    //Se especifica los atributos en un arreglo.
    protected $fillable = ['deviceId','date','url','latitude','longitude','positive','negative','warning'];

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
