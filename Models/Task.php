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
    
    public function add ($title, $description, $listID) {
        $now = date('Y-m-d H:i:s');
        $query = "INSERT INTO task (title, description, list_id, created_at, updated_at) VALUES ('$title', '$description', '$listID', '$now', '$now')";
        $this->db->query($query);
    }

    public function delete ($id) {
      $query = "DELETE FROM task WHERE id=$id";
      $this->db->query($query);
    }
}
