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
				array('val'=>'【会员卡号】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【会员姓名】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【出生日期】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【联系方式】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【联系地址】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【服务店家】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【会员积分】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【消费金额】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【购买产品】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【增值服务】','align'=>'center','width'=>16,'font-size'=>13),
				array('val'=>'【已消费服务】','align'=>'center','width'=>18,'font-size'=>13),
				array('val'=>'【未消费服务】','align'=>'center','width'=>18,'font-size'=>13),
		);
		$Vip=D('Vip');
		$Result=$Vip->getVipInfo(session('condition'),0,1);
		foreach($Result as $value)
		{
			$arr[] = array(
					array('val'=>''.$value['vcard'].'','align'=>'center'),
					array('val'=>''.$value['vname'].'','align'=>'center'),
					array('val'=>''.date("Y-m-d",$value['vbirth']).'','align'=>'center'),
					array('val'=>''.$value['vcontact_info'].'','align'=>'center'),
					array('val'=>''.$value['vcontact_address'].'','align'=>'center'),
					array('val'=>''.$value['vserver_owner'].'','align'=>'center'),
					array('val'=>''.$value['vintegral'].'','align'=>'center'),
					array('val'=>''.$value['vmoney'].'','align'=>'center'),
					array('val'=>''.$value['vproduct'].'','align'=>'center'),
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
			'Vip_Product'=>json_decode($VipInfo['list'][0]['vproduct']),
		));
		$this->display();
	}
	
	//vip_action
	public function vip_action()
	{
		$Manage_u=U('Vip/vip_manage');
		$PostData=I('post.');
		$VIP=D('Vip');
		
		switch(I('get.action'))
		{
			//添加
			case 'add':
                if(!IS_POST) break;
				$this->check_level('Vip/manage');
				$VIP->addVip($PostData) ? $this->success_($Manage_u) :  $this->error_($Manage_u);
				break;
			//删除
			case 'DeleteVip':
                if(!IS_POST) break;
				$this->check_level('Vip/manage');
				$D_Count=$VIP->deleteVip($PostData['vid']);
				$this->success_($Manage_u,"成功删除{$D_Count}位会员");
				break;
			//显示详细信息
			case 'ShowVipInfo':
                if(!IS_POST) break;
				$this->ajaxReturn($VIP->showVipInfo($PostData['v_id']),'EVAL');
				break;
			//设置会员礼品
			case 'setprosta':
                if(!IS_POST) break;
				$this->check_level('Vip/manage');
				$this->ajaxReturn($VIP->setProSta($PostData));
				break;
            //设置会员产品
            case 'setProduct':
                if(!IS_POST) break;
                $this->check_level('Vip/manage');
                $this->ajaxReturn($VIP->setProduct($PostData));
                break;
			//设置会员信息
			case 'set_vip':
                if(!IS_POST) break;
				$this->check_level('Vip/manage');
				$VIP->UpdateVip($PostData) ? $this->success_($Manage_u) : $this->error_($Manage_u);
				break;
            //初始化会员查询密码
            case 're_pass':
                $this->check_level('Vip/manage');
                echo $VIP->repass(I('get.re_vip_pass')) ? $this->success_($Manage_u) : $this->error_($Manage_u);
                break;
			case 'Upload_file':
                if(!IS_POST) break;
				$this->check_level('Vip/manage');
				$re=$VIP->Upload_File($PostData);
				$this->success_($Manage_u,"成功添加{$re}位会员");
                break;
			default:
				break;
		}
	}
	
}        

