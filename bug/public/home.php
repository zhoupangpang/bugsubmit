<?php

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 绑定到index模块
define('BIND_MODULE','home');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';