<?php

namespace Controllers;

use Models\TaskList;

/**
 * Class TaskListController
 * @package Controllers
 */
class TaskListController {
  private $list;

  public function __construct(TaskList $list) {
    $this->list = $list;
  }

  public function getAll()
  {
    $lists = $this->list->getAll();

    header('Content-type: application/json');
    echo json_encode($lists);
  }
}
