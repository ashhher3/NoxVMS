<?php 
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *nox_users MODEL
 */
 
namespace System\Model;
use Think\Model;

class UsersModel extends Model
{
	/*
	 *验证用户登录信息
	 *@param:string $username 账号
	 *@param:string $password 密码
	 *@return bool true|false
	 */
	public function Login($username,$password)
	{
		$first_query=$this->field('uid')->where("uname='$username'")->find();
		if(!$first_query['uid']) return false;
		
		$second_query=$this->where("uid={$first_query['uid']} and upass='".EnCode($password)."'")->find();
		if(!$second_query) return false;
		
		session('user_id',$second_query['uid']);
		session('user_name',$second_query['uname']);
		session('user_level',$second_query['ulevel']);
		
		//更新用户登录时间
		$this->where("uid={$second_query['uid']}")->save(array('ulogtime'=>time()));
		
		return true;
	}
	
	/*
	 *用户修改密码
	 *@param:array $data 
	 *@return int 1 修改成功
	 *		  int 0 修改失败
 	 */
	public function ChangePassword($data)
	{
		$old_pass=EnCode($data['old_pass']);
		$new_pass=EnCode($data['again_pass']);
		$userinfo['upass']=$new_pass;
		
		$res=$this->where("uid=".session('user_id')." and upass='$old_pass'")->save($userinfo);
		if(!$res) 
		{
			return 0;
		}
		else  return 1;
	}
	
	/*
	 *添加一位新用户
	 *@param:array $data 
	 *@return bool true|false
 	 */
	public function AddUser($data)
	{
		$udata['uname']=$data['uname'];
		$udata['upass']=EnCode($data['upass']);
		$udata['ulevel']=$data['ulevel'];
		
		if($this->where("uname='{$udata['uname']}'")->find()) return false;	//已存在用户名
		if($this->data($udata)->add()) return true;
		
		return false;
	}
	
	/*
	 *用户列表
	 *@return array  $list
	 *		  string $show		
 	 */
	public function QueryManage($page)
	{
		$list=$this->where('uid<>1')->page($page.',12')->select();
		$count=$this->where('uid<>1')->count();
		$Page= new \Think\Page($count,12);
		//设置分页样式
		$Page->setConfig('prev',C('PAGE_PREV'));
		$Page->setConfig('next',C('PAGE_NEXT'));
		$show=$Page->show();
		
		return array(
			'list'=>$list,
			'show'=>$show,
		);
	}
	
	/*
	 *删除用户
	 *@param:array $array 
	 *@return bool true|false	
 	 */
	public function DeleteManage($uid)
	{
		switch(session('user_level'))
		{
			case 1:
				$temp_str="and ulevel>1";
				break;
			case 0:
				$temp_str="and uid<>1";	
				break;
			default:
				$temp_str='';
				break;
		}
		if($this->where("uid=$uid $temp_str")->delete())
		{
			return true;
		}
		else return false;
	}
	
	/*
	 *修改用户数据
	 *@param:array $array
	 *@param:int $uid 用户ID
	 *@return bool true|false	
	 */
	public function UpdateUserInfo($array,$uid)
	{
		if($this->where("uid=$uid")->save($array))
		{
			return true;
		}
		else return false;
	}
	
	/*
	 *获取用户登录记录
	 *@return array
	 */
	public function getLog()
	{
		return $this->field('uname,ulogtime')->order('ulogtime desc')->limit(0,7)->select();
	}
		
}	