<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $fileUrl='./config.php';
        if(!file_exists($fileUrl))
        {
            echo '请勿重复安装';
        }
        else $this->display();
    }

    public function action()
    {
        if(IS_POST) exit('系统错误');
		
		$Host 	= $_POST['host'];
		$User 	= $_POST['user'];
		$PWD 	= $_POST['pwd'];
		$Dbname = $_POST['dbname'];

		if (empty($Host) && empty($User) && empty($Dbname)) exit('参数错误');
		
		$DB=new \PDO("mysql:host={$Host};", $User, $PWD);
		$DB->query("drop database if exists $Dbname");
		$DB->query("create database $Dbname");
		$Re=$DB->query("use $Dbname");
		if($Re)
		{
			if(file_exists('./noxvms.sql'))
			{
				$sql=file_get_contents('./noxvms.sql');
				$table=explode(';',$sql);
				foreach($table as $value) $DB->query($value);
				if(file_exists('./config.php'))
				{
					$config=file_get_contents('./config.php');
					$newConfig=str_replace(array('[$HOST]','[$NAME]','[$USER]','[$PWD]'),array($Host,$User,$PWD,$Dbname),$config);
					if(file_put_contents('./NoxVMS/Common/Conf/config.php',$newConfig))
					{
						$this->deldir('./Install');		
						unlink('./config.php');
						unlink('./noxvms.sql');
						unlink('./install.php');
					}
				}
			}
			else exit('安装数据已经损坏，请重新下载');
		}
		else exit("请检查数据库连接信息是否正确！<a href='".U('Index/index')."'>返回</a>");
    }
	
	public function deldir($dir) 
	{
	  //先删除目录下的文件：
		$dh=opendir($dir);
		while ($file=readdir($dh)) 
		{
			if($file!="." && $file!="..") 
			{
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) 
				{
					unlink($fullpath);
				} 
				else 
				{
					$this->deldir($fullpath);
				}
			}
		}
		closedir($dh);
		//删除当前文件夹：
		if(rmdir($dir))  return true;
		
		return false;
	}
}