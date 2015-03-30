<?php 
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *nox_global MODEL
 */
 
namespace System\Model;
use Think\Model;

class GlobalModel extends Model
{
	/*
	 *设置网站名称与生日提醒
	 *@param:array $data
	 *@return bool true|falsh
	 */
	public function _set($data)
	{
		if($this->where("gid=1")->save($data))
		{
			$GLOBALS['sitename']=$data['sitename'];
			$GLOBALS['birth']=$data['birth'];
			return true;
		}
		else return false;
	}
	
	/*
	 *获取网站配置
	 *@return array 
	 */
	public function _get()
	{
		return $this->where('gid=1')->find();
	}
}	