$(function(){
	var main_height=$(window).height();
	if(main_height < 600) main_height=600;
	$('.main').css('height',$(window).height()-20+"px");
	
})