<?php

namespace Models;

use Services\Database;

/**
 * Class Task
 * @package Models
 */
class Task {
  private $db;

  public function __construct (Database $db) {
    $this->db = $db;
  }

  public function getTask()
  {
    return $this->db->query('SELECT * FROM task');
  }
}
