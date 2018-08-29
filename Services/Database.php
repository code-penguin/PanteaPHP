<?php

namespace Services;

/**
 * Class Database
 * @package Services
 *
 * Handles database communication.
 */
class Database {
  private $connection;

  /**
   * Connect to the database.
   *
   * @return void
   * @throws \Exception
   */
  private function connect ()
  {
    $dbConfig = require_once 'config/configuration.php';
    list('host' => $host, 'port' => $port, 'database' => $database, 'username' => $username, 'password' => $password) = $dbConfig;

    $this->connection = new \mysqli($host, $username, $password, $database, $port);

    if ($this->connection->connect_errno) {
      throw new \Exception('Failed to connect to database');
    }
  }

  /**
   * Execute a query on the database.
   *
   * @param string $query
   * @return mixed
   * @throws \Exception
   */
  public function query(string $query)
  {
    if (!isset($this->connection)) {
      $this->connect();
    }

    return $this->connection->query($query);
  }

  /**
   * Execute a query on the database and return the result as an associative array.
   *
   * @param string $query
   * @return mixed
   * @throws \Exception
   */
  public function read(string $query)
  {
    $res = $this->query($query);
    return (!$res) ? $res : $res->fetch_all(MYSQLI_ASSOC);
  }
}
