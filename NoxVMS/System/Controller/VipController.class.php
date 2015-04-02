<?php
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *Vip Controller
 */
 
namespace System\Controller;
use Common\Controller\CommonController;

class VipController extends CommonController 
{
	public function __construct()
	{
		parent::__construct();
		Check_Login();
	}
	
	public function begin($controller)
	{
		$this->assign(array(
			'Vip_Nav'=>'active',
			"vip_{$controller}_active"=>'active',
		));
	}
	
	//vip_put_xlsx
	public function vip_put_xlsx()
	{
		$arr[] = array(
			array('val'=>'法铂丽红卡会员','align'=>'center','font-size'=>22,'colspan'=>12),
		);
		$arr[] = array(
				array('val'=>'【ID】','align'=>'center','font-size'=>13),
				array('val'=>'【会员卡号】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【会员姓名】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【出生日期】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【联系方式】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【联系地址】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【服务店家】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【店家号码】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【区域经理】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【拥有产品】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【已消费产品】','align'=>'center','width'=>18,'font-size'=>13),
				array('val'=>'【未消费产品】','align'=>'center','width'=>18,'font-size'=>13),
		);
		$Vip=D('Vip');
		$Result=$Vip->getVipInfo(session('condition'),0,1);
		foreach($Result as $value)
		{
			$arr[] = array(
					array('val'=>''.$value['vid'].'','align'=>'center'),
					array('val'=>''.$value['vcard'].'','align'=>'center'),
					array('val'=>''.$value['vname'].'','align'=>'center'),
					array('val'=>''.date("Y-m-d",$value['vbirth']).'','align'=>'center'),
					array('val'=>''.$value['vcontact_info'].'','align'=>'center'),
					array('val'=>''.$value['vcontact_address'].'','align'=>'center'),
					array('val'=>''.$value['vserver_owner'].'','align'=>'center'),
					array('val'=>''.$value['vserver_owner_number'].'','align'=>'center'),
					array('val'=>''.$value['varea_manager'].'','align'=>'center'),
					array('val'=>''.$value['vproject'].'','align'=>'center'),
					array('val'=>''.$value['vproject_consume'].'','align'=>'center'),
					array('val'=>''.$value['vproject_not_consume'].'','align'=>'center'),
			);
		}
		$excel=A('Excel');
		foreach($arr as $val)
		{
			$excel->setCells($val);
		}
		$excel->save();
	}
	
	//Index
	public function index()
	{
		$this->begin('query');
		$this->display();
	}
	
	//vip_query_list
	public function vip_query_list()
	{
		$this->begin('query');
		if(I('post.')) session('condition',I('post.'));
		$VipInfo=D('Vip')->getVipInfo(session('condition'), I('get.p',0));
		$this->assign(array(
			'vip_list' => $VipInfo['list'],
			'vip_show' => $VipInfo['show'],
		));
		$this->display();
	}

	//vip_manage
	public function vip_manage()
	{
		$this->begin('manage');
		$this->check_level('Vip/manage');
		$vip_list=D('Vip')->getVipInfo('', I('get.p',0));
		$this->assign(array(
			'project'=>D('Project')->getResult(),
			'vip_list'=>$vip_list['list'],
			'vip_show'=>$vip_list['show'],
		));
		$this->display();
	}
	
	//vip_set
	public function vip_set()
	{
		$this->begin('manage');
		$this->check_level('Vip/manage');
		$VipInfo=D('Vip')->getVipInfo(I('get.'),0);
		$this->assign(array(
			'project'=>D('Project')->getResult(),
			'VipInfo'=>$VipInfo['list'][0],
			'Vip_Project'=>json_decode($VipInfo['list'][0]['vproject']),
		));
		$this->display();
	}
	
	//vip_action
	public function vip_action()
	{
		
		if(!IS_POST) exit;
		
		$Manage_u=U('Vip/vip_manage');
		$PostData=I('post.');
		$VIP=D('Vip');
		
		switch(I('get.action'))
		{
			//添加
			case 'add':
				$this->check_level('Vip/manage');
				$VIP->addVip($PostData) ? $this->success_($Manage_u) :  $this->error_($Manage_u);
				break;
			//删除
			case 'deletevip':
				$this->check_level('Vip/manage');
				$D_Count=$VIP->deleteVip($PostData['vid']);
				$this->success_($Manage_u,"成功删除{$D_Count}位会员");
				break;
			//显示详细信息
			case 'showvipinfo':
				$this->ajaxReturn($VIP->showVipInfo($PostData['v_id']),'EVAL');
				break;
			//设置会员产品
			case 'setprosta':
				$this->check_level('Vip/manage');
				$this->ajaxReturn($VIP->setProSta($PostData));
				break;
			//设置会员信息
			case 'set_vip':
				$this->check_level('Vip/manage');
				$VIP->UpdateVip($PostData) ? $this->success_($Manage_u) : $this->error_($Manage_u);
				break;
			case 'upload_file':
				$this->check_level('Vip/manage');
				$re=$VIP->Upload_File($PostData);
				$this->success_($Manage_u,"成功添加{$re}位会员");
			default:
				break;
		}
	}
	
}        

