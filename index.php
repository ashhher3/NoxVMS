<?php
// +-------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +-------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +-------------------------------------------------
// | OSC	 [ http://git.oschina.net/sbcode/NoxVMS ]
// +-------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +-------------------------------------------------

//应用入口文件

//文档编码
header("Content-type:text/html;charset=UTF-8");

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//调试模式
define('APP_DEBUG',True);

//定义应用目录
define('APP_PATH','./NoxVMS/');

//定义上传目录
define('__UPLOAD__','/Upload');

//自定义安全文件内容
define('DIR_SECURE_CONTENT','<title>Error</title><h1>Directory Listing Denied</h1>');

//加载ThinkPHP框架
require './ThinkPHP/ThinkPHP.php';

