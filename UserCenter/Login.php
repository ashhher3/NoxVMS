<?php
/*-----------------------------------------------------------------------------
 * 法铂丽会员中心
 *-----------------------------------------------------------------------------
 * 登录
 */

# 声明文档编码
header("Content-type:text/html;charset=UTF-8");
#注册title全局常量
define('__TITLE__','登录 - 法铂丽会员中心');
#引入Global.php
include './Global.php';
if(!empty($_SESSION['token'])) session_destroy();

include './header.php';
?>
<div class="UserCenter">
    <div class="UCLogin">
        <div class="LeftBg"></div>
        <div class="Login">
            <div class="Login-top">会员中心</div>
            <form method="post" action="./Action.php">
                <input type="hidden" name="action" value="login" />
                <span>
                    <img src="./images/login/iconfont-huiyuanqia.png">
                    <input placeholder="请输入会员卡编号" type="text" required="required" name="card" />
                </span>
                <span>
                    <img src="./images/login/iconfont-mima.png">
                    <input placeholder="请输入查询密码" type="password" required="required" name="pass" />
                </span>
                <input class="submit" type="submit" value="查询" />
            </form>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>