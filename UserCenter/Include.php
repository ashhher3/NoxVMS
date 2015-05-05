<?php
/*-----------------------------------------------------------------------------
 * 法铂丽会员中心 - Include
 *-----------------------------------------------------------------------------
 *
 */

# 声明文档编码
header("Content-type:text/html;charset=UTF-8");
#注册title全局常量
define('__TITLE__','法铂丽会员中心');
#引入Global.php
include './Global.php';
#判断登录标识
if(empty($_SESSION['token'])) header('Location:./Login.php') ;