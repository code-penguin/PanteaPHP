<?php

namespace Controllers;

/**
 * Class ViewController
 * @package Controllers
 */
class ViewController {
  public function listTasklist () {
    require_once "views/tasklist.list.php";
  }

  public function viewTasklist () {
    require_once "views/tasklist.view.php";
  }

  public function addTasklist () {
    require_once "views/tasklist.form.php";
  }

  public function addTask () {
    require_once "views/task.form.php";
  }
}
