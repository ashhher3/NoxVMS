<?php 
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *nox_vip MODEL
 */
 
namespace System\Model;
use Think\Model;

class VipModel extends Model
{
	/*
	 *添加会员
	 *@param: array $data 
	 *@return bool
	 */
	public function addVip($data)
	{
        if(strlen($data['vcontact_info'])<6) return false;
		$vdata=array(
			'vcard'					=> $data['vcard'],
			'vname'					=> $data['vname'],
			'vbirth'				=> strtotime($data['vbirth']),
			'vcontact_info'			=> $data['vcontact_info'],
			'vcontact_address'		=> $data['vcontact_address'],
			'vserver_owner'			=> $data['vserver_owner'],
			'vserver_owner_number'	=> $data['vserver_owner_number'],
			'varea_manager'			=> $data['varea_manager'],
			'vproject'				=> json_encode($data['project']),
			'vproject_not_consume'	=> json_encode($data['project']),
			'vpass'	                => EnCrypt(substr($data['vcontact_info'],-6)),
		);
		if($this->where("vcard={$vdata['vcard']}")->find()) return false;
		if($this->data($vdata)->add()) return true;
		return false;
	}
	
	/*
	 *删除会员
	 *@param: array|int $vid
	 *@return int $i 返回删除成功条数
	 */
	public function deleteVip($vid)
	{
		$i=0;
		if(is_array($vid))
		{
			foreach($vid as $value)
			{
				$this->where("vid=$value")->delete() && $i++;
			}
		}
		else
		{
			$this->where("vid=$vid")->delete() && $i++;
		}
		return $i;
	}
	
	/*
	 *获取会员数据
	 *以nox_vip表任意字段为查询条件
	 *@param: array $data
	 *@return array $vipData
	 */
	public function getVipInfo($data,$page,$tot=0)
	{
		//$condition='1=1' 补充 SQL查询 条件
		//防止用户没有任何输入而导致查询失败，或者用户希望一次性全部列表...
		$condition='1=1';
		//将时间转化为时间戳
		$vip_birth_day=strtotime($data['vbirth']);
		//筛选条件拼接
		$data['vid'] && $condition.=" and vid={$data['vid']}";
		$data['vcard'] && $condition.=" and vcard={$data['vcard']}";
		$data['vname'] && $condition.=" and vname like '%{$data['vname']}%'";
		$data['vbirth'] && $condition.=" and vbirth={$vip_birth_day}";
		$data['vproject'] && $condition.=" and vproject='{$data['vproject']}'";
		$data['vcontact_info'] && $condition.=" and vcontact_info={$data['vcontact_info']}";
		$data['varea_manager'] && $condition.=" and varea_manager='{$data['varea_manager']}'";
		$data['vserver_owner'] && $condition.=" and vserver_owner='{$data['vserver_owner']}'";
		$data['vcontact_address'] && $condition.=" and vcontact_address='{$data['vcontact_address']}'";
		$data['vproject_consume'] && $condition.=" and vproject_consume='{$data['vproject_consume']}'";
		$data['vserver_owner_number'] && $condition.=" and vserver_owner_number={$data['vserver_owner_number']}";
		$data['vproject_not_consume'] && $condition.=" and vproject_not_consume='{$data['vproject_not_consume']}'";

		if($tot==1)
		{
            $Project=M('Project');
			$list=$this->where("{$condition}")->select();
			foreach($list as $key=>$value)
			{
				$vproject=json_decode($value['vproject']);
				$vproject_consume=json_decode($value['vproject_consume']);
				$vproject_not_consume=json_decode($value['vproject_not_consume']);
				foreach($vproject as $val)
				{
					$res=$Project->where("pid=$val")->find();
					$temp_vproject.=$res['pname'].",";
				}
				foreach($vproject_consume as $val1)
				{
					$res=$Project->where("pid=$val1")->find();
					$temp_vproject_consume.=$res['pname'].",";
				}
				foreach($vproject_not_consume as $val2)
				{
					$res=$Project->where("pid=$val2")->find();
					$temp_vproject_not_consume.=$res['pname'].",";
				}
				$list[$key]['vproject']=$temp_vproject;
				$list[$key]['vproject_consume']=$temp_vproject_consume;
				$list[$key]['vproject_not_consume']=$temp_vproject_not_consume;
			}
			return $list;
		}
		else
		{
			$list=$this->page($page.',12')->where("{$condition}")->select();
			$Page= new \Think\Page($this->count(),12);
			$Page->setConfig('prev',C('PAGE_PREV'));
			$Page->setConfig('next',C('PAGE_NEXT'));
			return array(
				'list'=>$list,
				'show'=>$Page->show(),
			);
		}
	}
	
	/*
	 *修改会员信息
	 *@param: array $data
	 *@return bool
	 */
	public function UpdateVip($data)
	{
		$vid=$data['vid'];
		unset($data['vid']);
		
		if(!empty($data['vproject']))
		{
			//获取会员已消费产品
			$vip_project_consume=$this->field('vproject_consume')->where("vid=$vid")->find();
			//获取会员未消费产品
			$vip_project_not_consume=$this->field('vproject_not_consume')->where("vid=$vid")->find();
			//获取最终会员已消费产品
			$vproject__consume=array_intersect(json_decode($vip_project_consume['vproject_consume']),$data['vproject']);
			//获取最终会员未消费产品
			foreach($data['vproject'] as $value)
			{
				if(!in_array($value,$vproject__consume))
				{
					$new_not_consume[]=$value;
				}
				else if(in_array($value,json_decode($vip_project_not_consume['vproject_not_consume'])))
				{
					$new_not_consume[]=$value;
				}
			}
			//格式化数组
			$new_not_consume=array_values($new_not_consume);
			$vproject__consume=array_values($vproject__consume);
		}
		
		$data['vbirth']=strtotime($data['vbirth']);
		$data['vproject']=json_encode($data['vproject']);
		$data['vproject_consume']=json_encode($vproject__consume);
		$data['vproject_not_consume']=json_encode($new_not_consume);
		
		return $this->where("vid=$vid")->save($data);
	}

	//获取会员列表
	public function vip_list($page)
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
	
	/*
	 *响应 Ajax用户详细信息
	 *样式若有更改需要在此一起更改
	 *@param: int $vid
	 *@return string $ReStr;
	 */
	public function ShowVipInfo($vid)
	{
		$result=$this->where("vid=$vid")->find();
		$Project=M('Project');
		if(session('user_level') <= session('Power.Vip/manage')) $level_sta=1;
		if(!empty($result['vproject_not_consume'])) 
		{
			$not_consume='';
			$vip_project=json_decode($result['vproject_not_consume']);
			foreach($vip_project as $value)
			{
				$pro_data=$Project->where("pid=$value")->find();
				if(isset($level_sta))
				{
					$temp_str='<a href="javascrip:;" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
								<ul class="dropdown-menu"><li name="consume" data-vip="'.$result['vid'].'" data-value="'.$pro_data['pid'].'"><a href="javascrip:;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 已消费</a></li>
								<li name="delete" data-vip="'.$result['vid'].'" data-value="'.$pro_data['pid'].'"><a href="javascrip:;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 删除</a></li></ul>';
				}
				$not_consume.='<div class="btn-group"><a href="javascrip:;" class="btn btn-sm btn-default">'.$pro_data['pname'].'</a>'.$temp_str.'</div>';
			}
		}
		if(!empty($result['vproject_consume'])) 
		{
			$_consume='';
			$vip_project=json_decode($result['vproject_consume']);
			foreach($vip_project as $value)
			{
				$pro_data=$Project->where("pid=$value")->find();
				if(isset($level_sta))
				{
					$temp_str='<a href="javascrip:;" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
							<ul class="dropdown-menu"><li name="consume" data-vip="'.$result['vid'].'" data-value="'.$pro_data['pid'].'"><a href="javascrip:;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 未消费</a></li>
							<li name="delete" data-vip="'.$result['vid'].'" data-value="'.$pro_data['pid'].'"><a href="javascrip:;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 删除</a></li></ul>';
				}
				$_consume.='<div class="btn-group"><a href="javascrip:;" class="btn btn-sm btn-default">'.$pro_data['pname'].'</a>'.$temp_str.'</div>';
			}
		}
		return $ReStr="<tr><td width='100'><strong>会员卡编号</strong></td><td>{$result['vcard']}</td></tr>
                <tr><td><strong>会员姓名</strong></td><td>{$result['vname']}</td></tr>
                <tr><td><strong>出生日期</strong></td><td>".date("Y-m-d",$result['vbirth'])."</td></tr>
                <tr><td><strong>联系方式</strong></td><td>{$result['vcontact_info']}</td></tr>
                <tr><td><strong>联系地址</strong></td><td>{$result['vcontact_address']}</td></tr>
                <tr><td><strong>服务店家</strong></td><td>{$result['vserver_owner']}</td></tr>
                <tr><td><strong>店家联系方式</strong></td><td>{$result['vserver_owner_number']}</td></tr>
                <tr><td><strong>区域经理</strong></td><td>{$result['varea_manager']}</td></tr>
                <tr><td><strong>未消费产品</strong></td><td class='pro_not_consume'><b></b>{$not_consume}</td></tr>
                <tr><td><strong>已消费产品</strong></td><td class='pro_consume'><b></b>{$_consume}</td></tr>";
	}
	
	
	/*
	 *变更用户产品状态
	 *@parat:$data
	 *@return 1|0
	 */
	public function setProSta($data)
	{
		$pid=$data['pid'];
		$sta=$data['sta'];
		$vid=$data['vid'];
		switch($sta)
		{
			//设置为已消费
			case 'consume':
				$vipinfo=$this->where("vid=$vid")->find();
			
				$consume=json_decode($vipinfo['vproject_consume']);
				$not_consume=json_decode($vipinfo['vproject_not_consume']);
				
				foreach($not_consume as $key=>$value) 
				{
					if($value==$pid) unset($not_consume[$key]);
				}
				
				$not_consume=array_values($not_consume);
				$consume[]=$pid;
				
				$Vdata['vproject_consume']=json_encode($consume);
				$Vdata['vproject_not_consume']=json_encode($not_consume);
				
				if($this->where("vid=$vid")->save($Vdata)) return 1;
				
				break;
			//设置为未消费	
			case 'not_consume':
				$vipinfo=$this->where("vid=$vid")->find();
			
				$consume=json_decode($vipinfo['vproject_consume']);
				$not_consume=json_decode($vipinfo['vproject_not_consume']);
				
				foreach($consume as $key=>$value) 
				{
					if($value==$pid) unset($consume[$key]);
				}
				
				$consume=array_values($consume);
				$not_consume[]=$pid;
				
				$Vdata['vproject_consume']=json_encode($consume);
				$Vdata['vproject_not_consume']=json_encode($not_consume);
				
				if($this->where("vid=$vid")->save($Vdata)) return 1;
			
				break;
			//删除	
			case 'delete':
				$vipinfo=$this->where("vid=$vid")->find();
			
				$consume=json_decode($vipinfo['vproject_consume']);
				$not_consume=json_decode($vipinfo['vproject_not_consume']);
				$project=json_decode($vipinfo['vproject']);
				
				foreach($not_consume as $key=>$value) if($value==$pid) unset($not_consume[$key]);
				foreach($project as $key=>$value) if($value==$pid) unset($project[$key]);
				foreach($consume as $key=>$value) if($value==$pid) unset($consume[$key]);
				
				$consume=array_values($consume);
				$project=array_values($project);
				$not_consume=array_values($not_consume);
				
				$Vdata['vproject']=json_encode($project);
				$Vdata['vproject_consume']=json_encode($consume);
				$Vdata['vproject_not_consume']=json_encode($not_consume);
				
				if($this->where("vid=$vid")->save($Vdata)) return 1;
				
				break;
			//break	
			default:
				break;
		}
		return 0;
	}
	
	/*
	 *获取用户生日提醒列表_带分页
	 *提醒期限由用户自定义
	 *算法说明：
	 *  获取会员生日月份与日期，计算时间戳时带上当前年份
	 *	将得到的会员今年生日时间戳，与当前时间戳对比
	 *	返回符合条件的会员
	 *@return array 
	 */
	public function getBirthList($page,$count=12)
	{
		$timer=$GLOBALS['birth']*86400;
		$result=$this->page($page.','.$count)->order("vbirth asc")->select();
		$Page= new \Think\Page($this->count(),$count);
		$Page->setConfig('prev',C('PAGE_PREV'));
		$Page->setConfig('next',C('PAGE_NEXT'));
		
		foreach($result as $value)
		{
			$userBirth=strtotime(date("Y-").date('m-d',$value['vbirth']));
			$today=strtotime(date("Y-").date('m-d'));
			$short_time=$userBirth-$today;
			if($short_time<=$timer && $short_time>=0)
			{
				$UserList[]=$value;
			}
		}
		
		return array(
			'UserList'=>$UserList,
			'show'=>$Page->show(),
		);
	}
	
	/*
	 *批量处理上传会员列表
	 *@param：$Data
	 *@return int $count
	 */
	public function Upload_File($Data)
	{
		//上传文件
		$config = array(
			'maxSize' => 0,
			'rootPath' => './Upload/vip/',
			'exts' => array('xlsx'),
			'replace'=>true,
			'autoSub' => true,
			'subName' => array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);
		$info=$upload->upload();
		if(!$info)
		{
			echo "<h1 style='font-size:60px'>".$upload->getError()."</h1>";
		}
		else
		{
			foreach($info as $fileInfo)
			{
				$inputFileName="./Upload/vip/".$fileInfo['savepath'].$fileInfo['savename'];
				$Dir_Path="./Upload/vip/".$fileInfo['savepath'];
			}
			//处理XLSX
			import("Vendor.Excel.PHPExcel.Reader.Excel2007");
			$inputFileType = 'Excel2007'; 
			$objReader = \PHPExcel_IOFactory::createReader($inputFileType);		
			$objPHPExcel = $objReader->load($inputFileName);
			$allColumn = $objPHPExcel->getSheet(0)->getHighestColumn(); 
			//行
			$allRow = $objPHPExcel->getSheet(0)->getHighestRow();
			//列数组
			$ColumnArray=array('A'=>0,'B'=>1,'C'=>2,'D'=>3,'E'=>4,'F'=>5,'G'=>6,'H'=>7,'I'=>8,'J'=>9,'K'=>10,'L'=>11,'M'=>12,
			'N'=>13,'O'=>14,'P'=>15,'Q'=>16,'R'=>17,'S'=>18,'T'=>19,'U'=>20,'V'=>21,'W'=>22,'X'=>23,'Y'=>24,'Z'=>25,'AA'=>26,
			'AB'=>27,'AC'=>28,'AD'=>29,'AE'=>30);
			//Y轴 
			for($j=3;$j<=$allRow;$j++)
			{
				//X轴
				for($i=0;$i<=$ColumnArray[$allColumn];$i++)
				{	
					//存数组
					$vip_array[$j][$i]=$objPHPExcel->getSheet(0)->getCellByColumnAndRow($i,$j)->getCalculatedValue();
				}
				$vip_list[$j]['vcard']=$vip_array[$j][0];
				$vip_list[$j]['vname']=$vip_array[$j][1];
				$vip_list[$j]['vbirth']=strtotime($vip_array[$j][2]);
				$vip_list[$j]['vcontact_info']=$vip_array[$j][3];
				$vip_list[$j]['vcontact_address']=$vip_array[$j][4];
				$vip_list[$j]['vserver_owner']=$vip_array[$j][5];
				$vip_list[$j]['vserver_owner_number']=$vip_array[$j][6];
				$vip_list[$j]['varea_manage']=$vip_array[$j][7];
				$vip_list[$j]['vproject']=$vip_array[$j][8];
				$vip_list[$j]['vproject_consume']=$vip_array[$j][9];
				$vip_list[$j]['vproject_not_consume']=$vip_array[$j][10];
			}
			$vip_list=array_values($vip_list);
			foreach($vip_list as $key=>$value)
			{
				$vproject=explode('，',$value['vproject']);
				foreach($vproject as $k=>$v) 
				{
					$res=D('Project')->field('pid')->where("pname='{$v}'")->find();
					$vproject[$k]=$res['pid'];
				}
				$vip_list[$key]['vproject']=json_encode($vproject);
				$vproject_consume=explode('，',$value['vproject_consume']);
				foreach($vproject_consume as $k=>$v) 
				{
					$res=D('Project')->field('pid')->where("pname='{$v}'")->find();
					$vproject_consume[$k]=$res['pid'];
				}
				$vip_list[$key]['vproject_consume']=json_encode($vproject_consume);
				$vproject_not_consume=explode('，',$value['vproject_not_consume']);
				foreach($vproject_not_consume as $k=>$v) 
				{
					$res=D('Project')->field('pid')->where("pname='{$v}'")->find();
					$vproject_not_consume[$k]=$res['pid'];
				}
				$vip_list[$key]['vproject_not_consume']=json_encode($vproject_not_consume);
			}
			$k=0;
			for($i=0,$c=count($vip_list);$i<$c;$i++)
			{
				if($this->where("vcard={$vip_list[$i]['vcard']}")->find()) continue;
				$this->data($vip_list[$i])->add() && $k++;
			}
			unlink($inputFileName);
			rmdir($Dir_Path);
			return $k;
		}
	}

    /*
     * 初始化会员查询密码
     * @param: int $vid
     * @return bool
     * */
    public function repass($vid)
    {
        if($vinfo=$this->where("vid=$vid")->find())
        {
            $vip_number=$vinfo['vcontact_info'];
            $vdata=array('vpass'=>EnCrypt(substr($vip_number,-6)));
            if($this->where("vid=$vid")->save($vdata)) return true;
        }
        return false;
    }

    /*
     * 验证会员身份
     **/
    public function vip_ver($card,$pass)
    {
        if($this->where("vcard='{$card}' and vpass='".EnCrypt($pass)."'")->find()) return true;
		return false;
    }
	
}	