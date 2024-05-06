<?php
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\AgendaController;
use App\Controllers\UserController;
use Middleware\JwtMiddleware;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$app = AppFactory::create();
//middleware do CORS
$app->add(require __DIR__ . '/../middleware/cors.php');
$app->add(new Middleware\CorsMiddleware());

//autoriza a rota options 
$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

//funcao para habilitar o cors
$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
    ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



//get
$app->get('/', UserController::class . ':teste');
//rotas sem JWT
$app->post('/api/user/create', UserController::class . ':createUser');
$app->post('/api/user/login', UserController::class . ':loginUser');
$app->post('/teste', UserController::class . ':testToken');
//rotas protegidas com jwt
$app->group('/api', function (RouteCollectorProxy $group) {
  $group->get('/users', UserController::class . ':getUsers');
  $group->get('/bookings', AgendaController::class . ':getAllBookings');
  $group->post('/booking/create', AgendaController::class . ':createBooking');
  $group->delete('/user/delete', UserController::class . ':deleteUser');
})->add(new JwtMiddleware());
  

$app->run();