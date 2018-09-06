<?php

use Services\Router;

// Forms application
Router::add('GET', '/', 'ViewController@listTasklist');
Router::add('GET', '/list', 'ViewController@viewTasklist');
Router::add('GET', '/list/add', 'ViewController@addTasklist');
Router::add('GET', '/task/add', 'ViewController@addTask');

// API
Router::add('GET', '/api/tasklists', 'TaskListController@getAll');
Router::add('POST', '/api/tasklist/add', 'TaskListController@add');
Router::add('GET', '/api/tasklist/{id}/tasks', 'TaskController@getAllForList');
Router::add('POST', '/api/task/add', 'TaskController@add');
Router::add('POST', '/api/task/delete', 'TaskController@delete');
