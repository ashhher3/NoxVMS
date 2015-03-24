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
 *Set Controller
 */
 
namespace System\Controller;
use Common\Controller\CommonController;

class SetController extends CommonController 
{
	public function __construct()
	{
		parent::__construct();
		Check_Login();
	}
	
	public function begin($controller='')
	{
		$this->assign(array(
			'Set_Nav'=>'active',
			'set_'.$controller.''=>'active',
		));
	}
	
	//Index
	public function index()
	{
		$this->check_level('Set/index');
		$this->begin('index');
		$this->assign("globalInfo",M('Global')->where("gid=1")->find());
		$this->display();
	}
	
	//set_manage
	public function set_manage()
	{
		$this->check_level('Set/manage');
		$this->begin('manage');
		$UserData=D('Users')->QueryManage(I('get.p')?I('get.p'):0);
		$this->assign(array(
			"user_result" => $UserData['list'],
			"show" => $UserData['show'],
			'power_name' => C('POWER_NAME'),
			'power_name_' => $this->getPowerName(),
		));
		$this->display();
	}
	
	//set_data
	public function set_data()
	{
		$this->begin('data');
		$this->display();
	}
	
	//set_action
	public function set_action()
	{
		if(!IS_POST) exit;
		$PostData=I('post.');
		switch(I('get.action'))
		{
			//常规设置
			case 'index':
				$this->check_level('Set/manage');
				D('Global')->_set($PostData) ? $this->success_(U('Set/index')) : $this->error_(U('Set/index'));
				break;
			//修改密码
			case 'data':
				$response=D('Users')->ChangePassword($PostData);
				$msg[0]="修改失败！请检查原密码是否填写正确！";
				$msg[1]="修改成功！";
				$this->success_(U('Set/set_data'),$msg[$response]);
				break;
			//添加用户
			case 'add':
				$this->check_level('Set/manage');
				$response=D('Users')->AddUser($PostData);
				if($response) $this->success_(U('Set/set_manage'));
				else $this->error_(U('Set/set_manage'),'添加失败，请检查用户是否存在');
				break;
			//删除一位用户
			case 'deleteOne':
				$this->check_level('Set/manage');
				$response=D('Users')->DeleteManage($PostData['userid']);
				$response ? $this->success_(U('Set/set_manage')) : $this->error_(U('Set/set_manage'));
				break;
			//删除选中用户
			case 'deleteCheck':
				$this->check_level('Set/manage');
				if(empty($PostData)) 
				{
					$this->error_(U('Set/set_manage'),"没有选中的用户！");
				}
				else
				{
					$i=0;
					$Users=D('Users');
					foreach($PostData['check'] as $value) $Users->DeleteManage($value) && $i++ ;
					$this->success_(U('Set/set_manage'),"成功删除{$i}位管理员");
				}
				break;
			//修改用户数据
			case 'UpdateData':
				$this->check_level('Set/manage');
				$udata['uname']=$PostData['uname'];
				!empty($PostData['upass']) && $udata['upass']=EnCode($PostData['upass']);
				if(D('Users')->UpdateUserInfo($udata,$PostData['uid']))
				{
					$this->success_(U('Set/set_manage'));
				}
				else $this->error_(U('Set/set_manage'));
				break;
			default:
				break;
		}
			
	}
	
}