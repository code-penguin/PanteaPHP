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
    return $this->db->read('SELECT * FROM tasklist');
  }

  public function add ($title, $description) {
    $now = date('Y-m-d H:i:s');
    $query = "INSERT INTO tasklist (title, description, created_at, updated_at) VALUES ('$title', '$description', '$now', '$now')";
    $this->db->query($query);
  }
}
