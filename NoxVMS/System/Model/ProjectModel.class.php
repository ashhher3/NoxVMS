<?php 
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *nox_project MODEL
 */
 
namespace System\Model;
use Think\Model;

class ProjectModel extends Model
{
	/*
	 *保存产品
	 *@param:array $data array('pname'=>,'pid'=>'','pdesc'=>'')
	 *@param:string $action 操作
	 *@return bool
	 */
	public function savePro($data,$action)
	{
		$pdata['pname']=$data['pname'];
		$pdata['pdesc']=$data['pdesc'];
		$pdata['cid']  =$data['cid'];
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
				return false;
				break;
		}
	}
	
	/*
	 *取项目列表
	 *param:int $page 页数
	 *return array
	 */
	public function query_pro_list($page)
	{
		$list=$this->join("nox_class ON nox_class.cid=nox_project.cid")->page($page.',12')->select();
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
        $Result=M('Class')->select();
        foreach($Result as $k=>$v)
        {
            $Result[$k]['Product']=$this->where('cid='.$v['cid'])->select();
        }
		return $Result;
	}
	
	#---------------------------------------分割线---------------------------------------
	
	/*操作分类*/
	public function saveClass($data,$action)
	{
		$M_Class=M('Class');
		$cdata['cname']=$data['cname'] 	? $data['cname'] : $data['pname'];
		$cdata['cdes'] =$data['cdes'] 	? $data['cdes']  : $data['pdesc'];
		switch($action)
		{
			case 'add':
				return $M_Class->data($cdata)->add();
				break;
			case 'save':
				return $M_Class->where("cid={$data['pid']}")->save($cdata);
				break;
			case 'delete':
				if($this->where("cid={$data['pid']}")->find())
				{
					return false;
				}
				else
				{
					return $M_Class->where("cid={$data['pid']}")->delete();
				}
				break;
			default:
				return false;
				break;
		}
	}
	
	/*
	 *取分类列表
	 *param:int $page 页数
	 *return array
	 */
	public function query_class_list($page)
	{
        if($page===false)
        {
            return M('Class')->select();
        }
        else
        {
            $list=M('Class')->page($page.',12')->select();
            $Page= new \Think\Page($this->count(),12);
            $Page->setConfig('prev',C('PAGE_PREV'));
            $Page->setConfig('next',C('PAGE_NEXT'));

            return array(
                'list'=>$list,
                'show'=>$Page->show(),
            );
        }
	}
	
	
}	