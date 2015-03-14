$(function(){
	$('.Login').css('marginTop',($(window).height()-$('.Login').height())/2);
})

//登录事件
function login()
{
	$('.Login .submit').hide();
	$('.Login .submit2').show();
	if($('[name=username]').val()!=='' && $('[name=password]').val()!=='')
	{
		$.post("/Login/response.html",{name:$('[name=username]').val(),pass:$('[name=password]').val()},function(data){
			if(data==1)
			{
				window.location.href="/";
			}
			else 
			{
				Message("用户名或密码错误");
				$('.Login .submit').show();
				$('.Login .submit2').hide();
			}
		},'html');
	}
	else
	{
		Message("用户名或者密码不能为空");
		$('.Login .submit').show();
		$('.Login .submit2').hide();
	}
}

//当焦点在密码框上时监听回车事件
function KeyDown(e)
{
	//兼容FF和IE和Opera    
	var theEvent = e || window.event;    
	var code = theEvent.keyCode || theEvent.which || theEvent.charCode;    
	if (code == 13)  login();  
}