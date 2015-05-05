<?php
// +---------------------------------------------------------------------------
// | NoxVMS  [ v0.1 ] 
// +---------------------------------------------------------------------------
// | Support [ ThinkPHP 3.2.3 http://thinkphp.cn ]
// +---------------------------------------------------------------------------
// | Autor   [ Hodge.Yuan@Hotmail.com ]
// +---------------------------------------------------------------------------

/*
 *CGI-Bin Controller
 */
 
namespace System\Controller;
use Think\Controller;

class CGIController extends Controller
{
    private $vip_card;
    private $vip_pass;
    private $vip_info=array();
    private $Return=array(
        100=>'Error Code: 100', //参数错误
        101=>'Error Code: 101', //没有数据
        102=>'Error Code: 102', //数据错误
    );
	
	#初始化检查来路GET参数
    public function _initialize()
    {
        I('get.card') ? $this->vip_card=I('get.card') : exit($this->Error[100]);
        $vip_info['vcard']=$this->vip_card;
    }

    #身份验证
    public function user_var()
    {
        //地址1：http://{HOST}/index.php/CGI/user_var?card={card}&pass={pass}
        //地址2：http://{HOST}/CGI/show_vip_info/card/{card}/pass/{pass}.html
        $Vip=D('Vip');
        $this->vip_pass=I('get.pass') ? I('get.pass') : false;
        if($Vip->vip_ver($this->vip_card,$this->vip_card))
        {
            $this->show_vip_info();
        }
        else  echo $this->Return[102];
    }
	
	#查询用户信息并返回json字符串
    public function show_vip_info()
    {
        //地址1：http://{HOST}/index.php/CGI/show_vip_info?card={card}
        //地址2：http://{HOST}/CGI/show_vip_info/card/{card}.html
        $Vip=D('Vip');
        $result=$Vip->getVipInfo(array('vcard'=>$this->vip_card),0,1);
        if($result) 
        {
           echo json_encode($result,true);
        }
        else echo $this->Return[101];
    }
}