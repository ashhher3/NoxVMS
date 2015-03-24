<?php 
// +-------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +-------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +-------------------------------------------------
// | Github	 [ https://github.com/nxcode/NoxVMS ]
// +-------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +-------------------------------------------------

/*
 *NoxVMS 公共函数库
 */
 
/*
 *检查登录状态
 *未登录 将跳转到登录页面
 */
function Check_Login()
{
	if(!session('?user_name') || !session('?user_id') || !session('?user_level'))
	{
		session_destroy();
		Jump(U('Login/login'));
	}
}

/*
 *检查客户端IP地址
 *IP列表->config.php IP_ADDRESS
 */
function Check_IP()
{
	$ip=get_client_ip();
	$conf=C('IP_ADDRESS');
	if(!empty($conf) && !in_array($ip,$conf)) exit("Incorrect IP address");
}

/*
 *停止程序执行并跳转
 *@param:string $url 跳转地址
 */
function Jump($url)
{
	header("Location:{$url}");
	exit;
}

/*
 *弹窗并跳转
 *param:string $Message 弹窗内容
 *param:string $url 跳转地址
 */
function Message($Message,$url)
{
	echo "
		<script src='/Public/SCWindow/jquery-1.11.1.min.js'></script>
		<script src='/Public/SCWindow/SCWindow.min.js'></script>
		<script>Message('$Message','$url')</script>
	";
}

/*
 *用户密码规则
 *@param:string $password 用户输入
 *@return string $code 
 */
function EnCode($password)
{
	$temp_str=MD5($password);
	$temp_substr=substr($temp_str,-16);
	return SHA1($temp_substr.$temp_str);
}