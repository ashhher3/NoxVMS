//修改密码前校对
function CheckPass(url,url2)
{
	var old_pass=$('input[name=old_pass]').val();
	var new_pass=$('input[name=new_pass]').val();
	var again_pass=$('input[name=again_pass]').val();
	
	if(old_pass=='') 
	{
		Message('请输入原密码！'); 
		return false;
	}
	else if(new_pass!==again_pass || new_pass=='' || again_pass=='')
	{
		Message('两次输入的密码不一致！'); 
		return false;
	}
	else true;
}

//删除管理员数据同步
function DeleteManage(uid,uname)
{
	$('#deleteUser .modal-title strong').html(uname);
	$('#deleteUser input[name=userid]').val(uid);
}

//删除选中管理员
function DeleteCheck()
{
	var obj=$('table input:checked');
	var str='';
	for(var i=0;i<obj.length;i++)
	{
		var inputObj=obj[i];
		str+="<input type='hidden' name='check[]' value='"+inputObj.value+"'>";
	}
	$('#deleteCheck form').append(str);
}

//修改用户数据
function UpdateData(uid,uname,ulevel)
{
	$('#UpdateData #inputName').val(uname);
	$('#UpdateData #hiddenUid').val(uid);
	var selectObj=$('#UpdateData #select option');
	for(var i=0,len=selectObj.length;i<=len;i++)
	{
		var inputValue=selectObj[i].value;
		if(inputValue==ulevel)
		{
			$('#UpdateData #select option[value='+ulevel+']').attr("selected","selected");
			break;
		}
	}
}
