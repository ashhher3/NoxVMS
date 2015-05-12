<?php
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

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
        $Project=D('Project');
		$Result=$Project->query_pro_list(I('get.p',0));
        $Class_Result=$Project->query_class_list(false);
		$this->assign(array(
			'pro_list'   => $Result['list'],
			'pro_show'   => $Result['show'],
            'class_list' => $Class_Result,
		));
		$this->display();
	}

    //pro_m_class
	public function m_class()
	{
        $this->begin();
		$Result=D('Project')->query_class_list(I('get.p',0));
		$this->assign(array(
			'class_list' => $Result['list'],
			'class_show' => $Result['show'],
		));
		$this->display();
	}
	
	//pro_action
	public function pro_action()
	{
		if(!IS_POST) exit;
		
		$_url=U('Project/index');
		$_url_class=U('Project/m_class');
		$Project=D('Project');
		$PostData=I('post.');
		switch(I('get.action'))
		{
			case 'add':
				$Project->savePro($PostData,'add')    ? $this->success_($_url)  : $this->error_($_url);
				break;
			case 'save':
				$Project->savePro($PostData,'save')   ? $this->success_($_url)  : $this->error_($_url);
				break;
			case 'delete':
				$Project->savePro($PostData,'delete') ? $this->success_($_url)	: $this->error_($_url);
				break;
			case 'addClass':
				$Project->saveClass($PostData,'add')    ? $this->success_($_url_class) : $this->error_($_url_class);
				break;
			case 'saveClass':
				$Project->saveClass($PostData,'save')   ? $this->success_($_url_class) : $this->error_($_url_class);
				break;	
			case 'deleteClass':
				$Project->saveClass($PostData,'delete') ? $this->success_($_url_class) : $this->error_($_url_class,'删除失败，请确认该分类已清空');
				break;	
			default:
				break;
		}
	}
	
	
}