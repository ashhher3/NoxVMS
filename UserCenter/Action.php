<?php
/*-----------------------------------------------------------------------------
 * 法铂丽会员中心
 *-----------------------------------------------------------------------------
 * 用户输入卡号查询相关信息
 */

# 声明文档编码
header("Content-type:text/html;charset=UTF-8");
#引入Global.php
include './Global.php';

if($_POST['action']=='login' && $_POST['card']!=='')
{
    $response=http_get("http://127.0.0.3/index.php/CGI/user_var?card={$_POST['card']}&pass={$_POST['pass']}");
    $res_array=json_decode($response,true);
    if($res_array[0]['vid'])
    {
        $_SESSION['vipinfo']= $res_array[0];
        $_SESSION['token']= $res_array[0]['vcard'];
        header('Location:./Index.php');
    }
    else echo "<script>alert('查询密码错误');location.href='./Login.php'</script>";
}