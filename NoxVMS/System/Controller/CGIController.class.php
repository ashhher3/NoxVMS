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
    private $vip_info=array(
        'vcard'=>'',
    );
    private $Error=array(
        100=>'Error Code: 100', //参数错误
        101=>'Error Code: 101', //没有数据
    );

    public function _initialize()
    {
        I('get.card') ? $this->vip_card=I('get.card') : exit($this->Error[100]);
        $vip_info['vcard']=$this->vip_card;
    }

    public function show_vip_info()
    {
        //地址1：http://？？/index.php/CGI/show_vip_info?card= ？？
        //地址2：http://？？/CGI/show_vip_info/card/？？.html
        $Vip=D('Vip');
        $result=$Vip->getVipInfo(array('vcard'=>$this->vip_card),0,1);
        if($result)
        {
           echo json_encode($result);
        }
        else echo $this->Error[101];
    }
}