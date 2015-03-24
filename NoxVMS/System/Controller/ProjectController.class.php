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
 *Project Controller
 */
 
namespace System\Controller;
use Common\Controller\CommonController;

class ProjectController extends CommonController 
{
	public function __construct()
	{
		parent::__construct();
		$this->check_level('Project');
		Check_Login();
	}
	
	public function begin()
	{
		$this->assign(array(
			'Project_Nav'=>'active',
		));
	}
	
	//pro_index
	public function index()
	{
		$this->begin();
		$Result=D('Project')->query_pro_list(I('get.p')?I('get.p'):0);
		$this->assign(array(
			'pro_list' => $Result['list'],
			'pro_show' => $Result['show'],
		));
		$this->display();
	}
	
	//pro_action
	public function pro_action()
	{
		if(!IS_POST) exit;
		
		$_url=U('Project/index');
		$Project=D('Project');
		$PostData=I('post.');
		switch(I('get.action'))
		{
			case 'add':
				$Project->savePro($PostData,'add') ? $this->success_($_url) : $this->error_($_url);
				break;
			case 'save':
				$Project->savePro($PostData,'save') ? $this->success_($_url) : $this->error_($_url);
				break;
			case 'delete':
				$Project->savePro($PostData,'delete') ? $this->success_($_url) : $this->error_($_url);
			default:
				break;
		}
	}
	
	
}