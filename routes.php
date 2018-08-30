<?php

return [
  // Forms application
  '/' => 'ViewController@listTasklist',
  '/list' => 'ViewController@viewTasklist',
  '/list/add' => 'ViewController@addTasklist',
  '/task/add' => 'ViewController@addTask',

  // API
  '/api/tasklists' => 'TaskListController@getAll',
  '/api/tasks' => 'TaskController@getAllForList',
  '/api/task/add' => 'TaskController@add',
  '/api/task/delete' => 'TaskController@delete'
];
