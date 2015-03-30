<?php 
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *登录
 */
 
namespace System\Controller;
use  Common\Controller\CommonController;

class LoginController extends CommonController
{
	public function begin()
	{
		if(session('?user_name') && session('?user_id') && session('?user_level'))
		{
			Jump(U('Index/index'));
		}
	}
	
	//登录
	public function login()
	{
		$this->begin();
		$this->display();
	}
	
	//Ajax响应
	public function response()
	{
		$this->begin();
		if(IS_AJAX)
		{
			if(D('Users')->Login(I('post.name'),I('post.pass'))) echo 1;
			else echo 0;
		}
	}
	
	//注销登录
	public function log_out()
	{
		session_destroy();
		Jump(U('Login/login'));
	}
	
}

