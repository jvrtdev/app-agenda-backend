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
    $sql = 'SELECT * FROM usuarios';
    
    $stmt = $this->database->getConnection()->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function loginUser($data)
  {
    $sql = 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha';

    $stmt = $this->database->getConnection()->prepare($sql);
    
    $stmt->bindValue(':email', $data->email);
    $stmt->bindValue(':senha', $data->senha);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se encontrou algum usuário com as credenciais fornecidas
    if ($user) {
        // Retorna os dados do usuário
        return $user;
    } else {
        // Retorna null se não encontrou nenhum usuário
        return null;
    }
    
  }
  
  public function createUser($data)
  {
    $sql = 'INSERT INTO usuarios (nome, email, senha, tipo, telefone) VALUES (:nome,:email,:senha,:tipo,:telefone)';
    
    $stmt = $this->database->getConnection()->prepare($sql);
    
    $stmt->bindValue(':nome', $data->nome);
    $stmt->bindValue(':email', $data->email);
    $stmt->bindValue(':senha', $data->senha);
    $stmt->bindValue(':tipo', $data->tipo);
    $stmt->bindValue(':telefone', $data->telefone);

    return $stmt->execute();
  }
  public function deleteUser($email)
  {
    $sql = 'DELETE FROM usuarios WHERE email=:emai';

    $stmt = $this->database->getConnection()->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
 
}