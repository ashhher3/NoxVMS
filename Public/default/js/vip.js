$(function(){
	//查询用户页面 查询按钮效果
	$('.vq-btn-form .vq-form-sub').click(function(){
		$('.vq-form-main').hide();
		$('.vq-form-loading').fadeIn();
	});
	//修改用户页面  保存按钮效果
	$('.vip_manage_set .vms_btn').click(function(){
		$(this).val('Loading...');
		$(this).addClass('disabled');
	});

    //添加用户 产品栏目 折叠
    $('.aucb p span,.aucb p a').click(function(){

        var Cobj=$(this).parent().parent();

        if(Cobj.find('.div').css('display')=='block')
        {
            Cobj.find('.div').css('display','none')
            Cobj.find('span').removeClass('glyphicon-chevron-down');
            Cobj.find('span').addClass('glyphicon-chevron-right');
        }
        else
        {
            Cobj.find('span').addClass('glyphicon-chevron-down');
            Cobj.find('span').removeClass('glyphicon-chevron-right');
            Cobj.find('.div').css('display','block')
        }
    });
    //checkbox状态切换
    $('.aucb p input[type=checkbox]').click(function(){
        var AucbDiv=$(this).parent().parent().find('.div');
        AucbDiv.find('input[type=checkbox]').prop('checked',this.checked);
    });
	
})

//显示会员信息
function ShowVipInfo(vid,vname,url)
{
	$('#UserInfo #myModalLabel').html(vname);
	$.post(url,{v_id:vid},function(data){
		$('#UserInfo table').html(data);
		//会员详细信息->更改产品
		$('#UserInfo .table li[name=consume]').on('click',function(){
			var td_class=$(this).parent().parent().parent('td').attr('class');
			//设置为已消费
			if(td_class=='pro_not_consume')
			{
				$(this).find('a').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 未消费');
				$(this).parent().parent('.btn-group').insertBefore($('.pro_consume b'));
				$.post('/Vip/vip_action/action/setprosta.html',{vid:$(this).attr('data-vip'),pid:$(this).attr('data-value'),sta:'consume'},function(data){
					if(data==0) 
					{
						alert('操作失败');
						window.location.href='/Vip/vip_manage.html';
					}
				},'html');
				
			}
			//设置为未消费
			else if(td_class=='pro_consume')
			{
				$(this).find('a').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 已消费');
				$(this).parent().parent('.btn-group').insertBefore($('.pro_not_consume b'));
				$.post('/Vip/vip_action/action/setprosta.html',{vid:$(this).attr('data-vip'),pid:$(this).attr('data-value'),sta:'not_consume'},function(data){
					if(data==0) 
					{
						alert('操作失败');
						window.location.href='/Vip/vip_manage.html';
					}
				},'html');
			}
		});
		//会员详细信息->将礼品删除
		$('#UserInfo .table li[name=delete]').on('click',function(){
            if(confirm('确认删除？'))
            {
                $(this).parent().parent('.btn-group').remove();
                $.post('/Vip/vip_action/action/setprosta.html', {
                    vid: $(this).attr('data-vip'),
                    pid: $(this).attr('data-value'),
                    sta: 'delete'
                }, function (data) {
                    if (data == 0) {
                        alert('操作失败');
                        window.location.href = '/Vip/vip_manage.html';
                    }
                });
            }
		});
        //会员详细信息->将购买产品删除
        $('#UserInfo .table li[name=deleteProduct]').on('click',function(){
            if(confirm('确认删除？'))
            {
                $(this).parent().parent('.btn-group').remove();
                $.post('/Vip/vip_action/action/setProduct.html',{vid:$(this).attr('data-vip'),pid:$(this).attr('data-value'),sta:'delete'},function(data){
                    if(data==0)
                    {
                        alert('操作失败');
                        window.location.href='/Vip/vip_manage.html';
                    }
                });
            }
        });
	},'html');
}

//删除一位会员
function DeleteVip_One(vid,vname)
{
	$('#DeleteUser_One .modal-title strong').html(vname);
	$('#DeleteUser_One .modal-body input[name=vid]').val(vid);
}

//删除选中会员
function DeleteVipCheck()
{
	var obj=$(".table-hover input:checkbox[name='ckname']:checked") ;
	var str='';
	for(var i=0;i<obj.length;i++)
	{
		var inputObj=obj[i];
		str+="<input type='hidden' name='vid[]' value='"+inputObj.value+"'>";
	}
    $('#DeleteUser_Focus form input[type=hidden]').remove();
	$('#DeleteUser_Focus form').append(str);
}

//重置用户密码
function re_vip_password(url)
{
    SCWindow('警告','确认重置该用户密码？','B',url);
}