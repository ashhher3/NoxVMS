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
 *nox_project MODEL
 */
 
namespace System\Model;
use Think\Model;

class ProjectModel extends Model
{
	/*
	 *保存产品
	 *param:array $data array('pname'=>,'pid'=>'','pdesc'=>'')
	 *param:string $action 操作
	 *return bool
	 */
	public function savePro($data,$action)
	{
		$pdata['pname']=$data['pname'];
		$pdata['pdesc']=$data['pdesc'];
		switch($action)
		{
			case 'add':
				return $this->data($pdata)->add();
				break;
			case 'save':
				return $this->where("pid={$data['pid']}")->save($pdata);
				break;
			case 'delete':
				if($this->where("pid={$data['pid']}")->delete())
				{
					$Vip=D('Vip');
					$VipResult=$Vip->select();
					foreach($VipResult as $value)
					{
						$vdata=array(
							'pid'=>$data['pid'],
							'sta'=>'delete',
							'vid'=>$value['vid'],
						);
						$Vip->setProSta($vdata);
					}
					return true;
				}
				else return false;
			default:
				break;
		}
	}
	
	/*
	 *取列表
	 *param:int $page 页数
	 *return array
	 */
	public function query_pro_list($page)
	{
		$list=$this->page($page.',12')->select();
		$Page= new \Think\Page($this->count(),12);
		$Page->setConfig('prev',C('PAGE_PREV'));
		$Page->setConfig('next',C('PAGE_NEXT'));
		
		return array(
			'list'=>$list,
			'show'=>$Page->show(),
		);
	}
	
	//获取所有产品
	public function getResult()
	{
		return $this->select();
	}
	
	
}	