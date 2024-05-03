<?php
namespace App\Controllers;

use App\Database;
use App\Repositories\UserRepository;
use App\Services\Auth;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UserController{
  protected $userRepository;

  protected $auth;

    public function __construct()
    {
      $database = new Database;

      $this->userRepository = new UserRepository($database);
      
      $this->auth = new Auth();
    }

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
      $body = $request->getBody();
      $data = json_decode($body);
    
      
      $result = $this->userRepository->createUser($data);
      if($result){
        $response->getBody()->write(json_encode(['message' => 'User created successfully']));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message' => 'Failed to create user']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');

    }
    public function loginUser(Request $request, Response $response)
    {
      $body = json_decode($request->getBody());
      
      $result = $this->userRepository->loginUser($body);
      
      if($result){
        $token = $this->auth->createToken($result);
    
        // Retorna o token JWT no cabeçalho de autorização
        $response = $response->withHeader('Authorization', $token);
        
        $response->getBody()->write(json_encode(['message'=>'Usuario logado com sucesso!']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message'=>'Erro ao logar usuario, verifique as credenciais']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');  
    }


    public function deleteUser(Request $request, Response $response)
    {
      $body = $request->getBody();
      $data = json_decode($body);
      
      $result = $this->userRepository->deleteUser($data->email);
      if($result){
        $response->getBody()->write(json_encode("Usuario excluido com sucesso!"));
        return $response->withStatus(200)->withHeader('Content-Type','application/json');
      }
      $response->getBody()->write(json_encode($result));
      return $response->withStatus(200)->withHeader('Content-Type','application/json');
    }
    public function testToken(Request $request, Response $response)
    {
      $data = json_decode($request->getBody());
      $result = $this->userRepository->loginUser($data);
      
      if($result){
        $token = $this->auth->testToken($result);
        $response->getBody()->write(json_encode($token));
        return $response->withStatus(200)->withHeader('Content-Type','application/json');
      }
      
      
      $response->getBody()->write(json_encode("deu ruim"));
        return $response->withStatus(400)->withHeader('Content-Type','application/json');
      
    }
}