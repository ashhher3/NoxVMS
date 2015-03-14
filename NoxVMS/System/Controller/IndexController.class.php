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

/*
 *Index Controller
 */
 
namespace System\Controller;
use Common\Controller\CommonController;

class IndexController extends CommonController 
{
	public function __construct()
	{
		parent::__construct();
		Check_Login();
	}
	
	public function begin()
	{
		$this->assign(array(
			'Index_Nav'=>'active',
		));
	}
	
	//Index
	public function index()
	{
		$this->begin();
		$Result=D('Vip')->getBirthList(0,5);
		$this->assign(array(
			'log'=>D('Users')->getLog(),
			'U_List'=>$Result['UserList'],			
		));
		$this->display();
	}
	
	//列表
	public function birth()
	{
		$this->begin();
		$Result=D('Vip')->getBirthList(I('get.p')?I('get.p'):0,12);
		$this->assign(array(
			'U_List'=>$Result['UserList'],			
			'show'=>$Result['show'],			
		));
		$this->display();
	}
	
}