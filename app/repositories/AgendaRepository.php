<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Database;
use PDO;

class AgendaRepository
{
  protected $database;

  public function __construct(Database $database)
  {
    $this->database = $database;
  }


  public function getAllBookings()
  {
    $sql = 'SELECT * FROM agendamentos';

    $stmt = $this->database->getConnection()->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function createNewBooking($data)
  {
    $sql = 'INSERT INTO agendamentos(cliente_id, barbeiro_id, data_hora, status, horario_inicio, horario_fim) VALUES(:cliente_id,:barbeiro_id,:data_hora,:status,:horario_inicio,:horario_fim)';

    $stmt = $this->database->getConnection()->prepare($sql);

    $stmt->bindValue(':cliente_id', $data->cliente_id);
    $stmt->bindValue(':barbeiro_id', $data->barbeiro_id);
    $stmt->bindValue(':data_hora', $data->data_hora);
    $stmt->bindValue(':status', $data->status);
    $stmt->bindValue(':horario_inicio', $data->horario_inicio);
    $stmt->bindValue(':horario_fim', $data->horario_fim);

    return $stmt->execute();
  }
}