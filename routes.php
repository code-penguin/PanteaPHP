<?php

return [
  '/' => 'ViewController@listTasklist',
  '/list' => 'ViewController@viewTasklist',
  '/list/add' => 'ViewController@addTasklist',
  '/task/add' => 'ViewController@addTask',
  '/api/tasklist/all' => 'TaskListController@getAll'
];
