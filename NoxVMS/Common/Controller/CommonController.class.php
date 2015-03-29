<?php 
// +-------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +-------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +-------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +-------------------------------------------------

/*
 *common controller
 */

namespace Common\Controller;
use Think\Controller;

class CommonController extends Controller
{
	//网页标题与用户生日提醒日期 && IP限制
	public function __construct()
	{
		Check_IP();
		parent::__construct();
		$system_info=D('System/Global')->_get();
		session('Power',C('POWER_CONTRO'));
		$GLOBALS['birth']=$system_info['birth'];
		$GLOBALS['sitename']=$system_info['sitename'];
	}
	
	//抓取用户权限等级
	public function getPowerName()
	{
		$power=C('POWER_NAME');
		unset($power[0]);
		return $power;
	}
	
	/*
	 *ThinkPHP默认跳转方式-操作成功
	 *@param:string $url  跳转地址
	 *@param:int 	$time 跳转延时
	 *@param:string $msg  提示信息
	 */ 
	public function success_($url,$msg='',$time=1)
	{
		empty($msg) && $msg=C('SUCCESS_MSG');
		$this->success($msg,$url,$time);
	}

	/*
	 *ThinkPHP默认跳转方式-操作失败
	 *param:string  $url  跳转地址
	 *param:int 	$time 跳转延时
	 *param:string  $msg  提示信息
	 */ 
	public function error_($url,$msg='',$time=2)
	{
		empty($msg) && $msg=C('ERROR_MSG');
		$this->error($msg,$url,$time);
	}
	
	//检查用户权限
	public function check_level($controller)
	{
		$power=C('POWER_CONTRO');
		$level=$power[$controller];
		$user_level=session('user_level');
		if($user_level>$level)
		{
			$this->error_("权限不足",U('Inedex/index'));
			exit;
		}
	}
	
}
