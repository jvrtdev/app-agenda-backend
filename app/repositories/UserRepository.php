<?php
declare(strict_types=1);

namespace App\Repositories;
use App\Database;
use PDO;

class UserRepository
{
  protected $database;
  
  public function __construct(Database $database)
  {
    $this->database = $database;
  }

  public function getUsers()
  {
    $sql = 'SELECT * FROM clientes';
    
    $stmt = $this->database->getConnection()->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function loginUser($data)
  {
    $sql = 'SELECT * FROM clientes WHERE email = :email AND senha = :senha';

    $stmt = $this->database->getConnection()->prepare($sql);
    
    $stmt->bindValue(':email', $data->email);
    $stmt->bindValue(':senha', $data->senha);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    
  }
  
  public function createUser($data)
  {
    $sql = 'INSERT INTO clientes (nome, email, senha, celular, foto_perfil) VALUES (:nome,:email,:senha,:celular,:foto_perfil)';
    
    $stmt = $this->database->getConnection()->prepare($sql);
    
    $stmt->bindValue(':nome', $data->nome);
    $stmt->bindValue(':email', $data->email);
    $stmt->bindValue(':senha', $data->senha);
    $stmt->bindValue(':celular', $data->celular);
    $stmt->bindValue(':foto_perfil', $data->foto_perfil);

    return $stmt->execute();
  }
  public function deleteUser($email)
  {
    $sql = 'DELETE FROM clientes WHERE email=:emai';

    $stmt = $this->database->getConnection()->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
 
}