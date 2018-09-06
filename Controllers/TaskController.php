<?php

namespace Controllers;

use Models\Task;

/**
 * Class TaskController
 * @package Controllers
 */
class TaskController
{
  private $task;

  public function __construct(Task $task) {
    $this->task = $task;
  }

  public function add() {
    $this->task->add($_REQUEST['title'], $_REQUEST['description'], $_REQUEST['list_id']);
  }

  public function delete() {
    $this->task->delete($_REQUEST['id']);
  }

  public function getAllForList(array $params) {
    $tasks = $this->task->allForList($params['id']);

    header('Content-type: application/json');
    echo json_encode($tasks);
  }
}
