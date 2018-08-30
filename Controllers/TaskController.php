<?php

namespace Controllers;

use Models\Task;

/**
 * Class TaskController
 * @package Controllers
 */
class TaskController {
    private $task;
    
    public function __construct(Task $task) {
        $this->task = $task;
    }
    
    public function add () {
        $this->task->add($_REQUEST['title'], $_REQUEST['description'], $_REQUEST['list_id']);
    }
}
