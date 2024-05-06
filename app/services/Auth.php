<?php
declare(strict_types=1);
namespace App\Services;

use App\Database;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Class Auth
{
  protected string $secret_key;
  
  protected int $time;

  protected $userRepository;

  public function __construct()
  {
    $this->secret_key = "minhachavesecreta";

    $database = new Database;
      
    $this->userRepository = new UserRepository($database);
  }
  
  public function createToken($userData)
  {


    $payload = [
      'email' => $userData['email'],
      'senha' => $userData['senha'],
    ];
    
    $jwt = JWT::encode($payload, $this->secret_key , 'HS256');//args->informacoes, chave secreta, criptografia
    
    return $jwt;
  }
  public function testToken($data)
  {
    $now = time();
    $expirationTime = $now + $this->time;

    $payload = [
      'email' => $data['email'],
      'senha' => $data['senha'],
      'exp' => $expirationTime,
    ];
    
    $jwt = JWT::encode($payload, $this->secret_key , 'HS256');//args->informacoes, chave secreta, criptografia
    $decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
    return $jwt;
  }

}