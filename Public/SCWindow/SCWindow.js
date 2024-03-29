﻿/*************************Hodge.Yuan@Hotmail.com***************************
 *
 *	SCWindow(title,content,[show],[url]):带标题 和确认按钮与取消按钮的对话框
 *  Message(content,[show],[url])：带确认、取消按钮的对话框
 *
 * 	title：标题
 *	content：内容
 *	show：样式，值为：A\B两种[可选填]
 *	url：跳转地址，值自定义[可选填]
 *	
 *	注意：若需要跳转页面，请务必填写[show]，否则将跳转不成功。
 * 	如果弹窗被挡住没有置顶的话请修改#WinMain 的z-index值
 *
 *************************Hodge.Yuan@Hotmail.com***************************/

function Style()
{
	$('#AlertWindow input,#AlertWindow font').css('outline','none');
	$('#AlertWindow').css({'width':'100%','height':'100%','position':'fixed','top':'0px','left':'0px'});
	$('#AlertWindow').css({'margin':'0px auto','fontFamily':'微软雅黑','zIndex':'99999999998'});
	$('#WinBg').css({'width':'100%','height':'100%','position':'fixed','top':'0px','backgroundColor':'#000','opacity':'0.5','zIndex':'99999999999'});
	$('#WinMain').css({'width':'460px','position':'absolute','top':'25%','margin':'0px auto','padding':'0px'});
	$('#WinMain').css({'zIndex':'99999999999999','border':'0px solid #e6e6e6','overflow':'hidden','boxShadow':'0 5px 15px rgba(0,0,0,0.5)'});
	$('#WMTitle').css({'height':'40px','width':'100%','background':'#FFF','border-bottom':'1px solid #e6e6e6','color':'#000','lineHeight':'40px'});
	$('#WMTitle').css({'paddingLeft':'8px','overflow':'hidden','cursor':'move'});
	$('#WMTitle p').css({'float':'left','height':'100%','margin':'0px','padding':'0px'});
	$('#WMTitle font').css({'float':'right','display':'block','marginRight':'20px','fontSize':'17px','cursor':'pointer','color':'#999'});
	$('#WMTitle font').hover(function(){$(this).css('color','#000')},function(){$(this).css('color','#999')});
	$('#WMContent').css({'width':'100%','height':'170px','backgroundColor':'#FFF','fontSize':'18px','paddingTop':'10%'});
	$('#WMContent p').css({'width':'95%','margin':'0px auto','textAlign':'center'});
	$('#WMContent span').css({'width':'100%','height':'50px','position':'absolute','bottom':'0px','textAlign':'center'});
	$('#WMContent span input').css({'width':'100px','height':'35px','position':'absolute','fontSize':'15px','fontFamily':'微软雅黑'});
	$('#WMContent span input').css({'color':'#FFF','cursor':'pointer','border':'none'});
	$('#WMCconfirm').css({'backgroundColor':'#093','left':'80px','border':'none'});
	$('#WMCcancel').css({'backgroundColor':'#F90','right':'80px','border':'none'});
	$('#WMCconfirm').hover(function(){$(this).css('backgroundColor','#000')},function(){$(this).css('backgroundColor','#093')});
	$('#WMCcancel').hover(function(){$(this).css('backgroundColor','#000')},function(){$(this).css('backgroundColor','#F90')});
}

function SCWindow(title,content,show,url)
{
	
	if(show=="A")
	{
		var con ="<div id='AlertWindow'><div id='WinBg'></div><div id='WinMain'><div id='WMTitle'><p>"+title+"</p><font onClick='Ok_Confirm(\""+url+"\")'>X</font></div><div id='WMContent'><p>"+content+"</p><span id='AW_URL' title='"+url+"'><input onClick='Ok_Confirm(\""+url+"\")' id='WMCconfirm' type='button' value='确定' style='position:none;margin-left:105px;'  /></span></div></div></div>";
		var WMTitleStyle={'color':'#000','border-bottom':'0px'};
	}
	else
	{
		var con =" <div id='AlertWindow'><div id='WinBg'></div><div id='WinMain'><div id='WMTitle'><p>"+title+"</p><font onClick='No_Confirm()'>X</font></div><div id='WMContent'><p>"+content+"</p><span id='AW_URL' title='"+url+"'><input onClick='Ok_Confirm(\""+url+"\")' id='WMCconfirm' type='button' value='确定'  /><input onClick='No_Confirm()' id='WMCcancel' type='button' value='取消'  /></span></div></div></div>";
	}
	
	$('html').append(con);
	$('#WMCconfirm').focus();
	Style();
	Drag();
	$('#WMTitle').css(WMTitleStyle);
}

function Message(content,url)
{
	var con =" <div id='AlertWindow'><div id='WinBg'></div><div id='WinMain'><div id='WMTitle'><font onClick='Ok_Confirm(\""+url+"\")'>X</font></div><div id='WMContent'><p>"+content+"</p><span id='AW_URL' title='"+url+"'><input onkeydown='EnterClose(e)' onClick='Ok_Confirm(\""+url+"\")' id='WMCconfirm' type='button' value='确定' style='position:none;margin-left:105px;'  /></span></div></div></div>";
	var WMTitleStyle={'border-bottom':'0px'};
	$('html').append(con);
	$('#WMCconfirm').focus();
	Style();
	Drag();
	$('#WMTitle').css(WMTitleStyle);
}

function Ok_Confirm(url)
{
	$('#AlertWindow').slideToggle(100);
	setTimeout("$('#AlertWindow').remove()",100);
	
	if(url)
	{
		if(url.length>1 && url!=='undefined')
		{
			setTimeout("window.location='"+url+"'",200)
		}
	}
}

function No_Confirm()
{
	$('#AlertWindow').slideToggle(100);
	setTimeout("$('#AlertWindow').remove()",100);
}

//拖动窗口·
function Drag()
{
	//初始化窗口居中
	var F_Width=$('#AlertWindow').width();
	var M_Width=$('#WinMain').width();
	var Wth=(F_Width-M_Width)/2;
	$('#WinMain').css('left',Wth+'px');
		
	//移动
	$('#WMTitle').mousedown(function(event){
		var isMove = true;
		var WD_X = event.clientX - document.getElementById('WinMain').offsetLeft; 
		var WD_Y = event.clientY - document.getElementById('WinMain').offsetTop;
		
		$(document).mousemove(function(event){
			if(isMove) 
			{
				var x=event.clientX - WD_X;
				var y=event.clientY - WD_Y;
				
				var maxL = $('#AlertWindow').width() - $('#WinMain').outerWidth();
				var maxT = $('#AlertWindow').height() - $('#WinMain').outerHeight(); 
				      
				x = x < 0 ? 0 : x;
				x = x > maxL ? maxL : x;
				y = y < 0 ? 0 : y;
				y = y > maxT ? maxT : y;
				
				$('#WinMain').css({'left':x, 'top':y});
			}
		}).mouseup(function(){
			isMove = false; 
		});
	});
}