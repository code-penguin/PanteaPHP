<?php

namespace Models;

use Services\Database;

/**
 * Class TaskList
 * @package Models
 */
class TaskList {
  private  $db;

  public function __construct (Database $db) {
    $this->db = $db;
  }

  public function getAll()
  {
    return $this->db->query('SELECT * FROM tasklist');
  }
}
