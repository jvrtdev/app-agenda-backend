<?php
namespace App\Controllers;
use App\Database;
use App\Repositories\AgendaRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AgendaController
{
  public function getAllBookings(Request $request, Response $response)
  {
    $database = new Database();
    $repository = new AgendaRepository($database);

    $data = $repository->getAllBookings();

    $response->getBody()->write(json_encode($data));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
  }
  public function createBooking(Request $request, Response $response)
  {
    $database = new Database();
    $repository = new AgendaRepository($database);

    $body = $request->getBody();
    $data = json_decode($body);

    $result = $repository->createNewBooking($data);

    if($result){
      $response->getBody()->write(json_encode(['message' => 'Booking created successfully']));
      return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
    $response->getBody()->write(json_encode(['message' => 'Erro ao criar agendamento!']));
    return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
  }
}
