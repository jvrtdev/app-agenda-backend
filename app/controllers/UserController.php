<?php
namespace App\Controllers;

use App\Database;
use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UserController{
    public function teste(Request $resquest, Response $response)
    {
      $response->getBody()->write(json_encode("API RODANDO"));
      return $response->withHeader('Content-Type', 'application/json');
    }
    public function getUsers(Request $request, Response $response)
    {
      $database = new Database();
      $repository = new UserRepository($database);

      $data = $repository->getUsers();

      $response->getBody()->write(json_encode($data));
      return $response->withHeader('Content-Type', 'application/json');
    }
    public function createUser(Request $request, Response $response)
    {
      $database = new Database();
      $repository = new UserRepository($database);
      
      $body = $request->getBody();
      $data = json_decode($body);
    
      
      $result = $repository->createUser($data);
      if($result){
        $response->getBody()->write(json_encode(['message' => 'User created successfully']));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message' => 'Failed to create user']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');

    }
    public function loginUser(Request $request, Response $response)
    {
      $database = new Database();
      $repository = new UserRepository($database);

      $body = $request->getBody();
      $data = json_decode($body);
      
      $result = $repository->loginUser($data);
      if($result != null){
        $response->getBody()->write(json_encode(['message'=>'Usuario logado com sucesso!']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message'=>'Erro ao logar usuario, verifique as credenciais']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');  
    }


    public function deleteUser(Request $request, Response $response)
    {
      $database = new Database();
      $repository = new UserRepository($database);
      $body = $request->getBody();
      $data = json_decode($body);
      
      $result = $repository->deleteUser($data->email);
      if($result){
        $response->getBody()->write(json_encode("Usuario excluido com sucesso!"));
        return $response->withStatus(200)->withHeader('Content-Type','application/json');
      }
      $response->getBody()->write(json_encode($result));
      return $response->withStatus(200)->withHeader('Content-Type','application/json');
    }
}