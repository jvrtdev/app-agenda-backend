<?php

use App\Controllers\AgendaController;
use App\Controllers\UserController;
use Slim\Factory\AppFactory;
// use Slim\Routing\RouteCollectorProxy;
// use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Server\RequestHandlerInterface;



require __DIR__ . '/../vendor/autoload.php';




$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$app = AppFactory::create();
//middleware do CORS
$app->add(require __DIR__ . '/../middleware/cors.php');

// Rota OPTIONS genérica para lidar com solicitações OPTIONS
$app->options('/{routes:.*}', function (Request $request, Response $response) {
  return $response;
});
// $app->addBodyParsingMiddleware();

// // This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
// $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
//   $response = $handler->handle($request);

//   $response = $response->withHeader('Access-Control-Allow-Origin', '*');
//   $response = $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//   $response = $response->withHeader('Access-Control-Allow-Headers', '*');

//   // Optional: Allow Ajax CORS requests with Authorization header
//   $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

//   return $response;
// });

// // The RoutingMiddleware should be added after our CORS middleware so routing is performed first
// $app->addRoutingMiddleware();


//get
$app->get('/', UserController::class . ':teste');
$app->get('/api/users', UserController::class . ':getUsers');
$app->get('/api/bookings', AgendaController::class . ':getAllBookings');
//post
$app->post('/api/user/create', UserController::class . ':createUser');
$app->post('/api/user/login', UserController::class . ':loginUser');
$app->post('/api/booking/create', AgendaController::class . ':createBooking');
//gelete
$app->delete('/user/delete', UserController::class . ':deleteUser');

$app->run();