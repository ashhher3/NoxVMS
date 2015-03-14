function Modify_Project(pid,pname,pdesc)
{
	$('#ChangeData input[name=pname]').val(pname);	
	$('#ChangeData textarea[name=pdesc]').val(pdesc);	
	$('#ChangeData input[name=pid]').val(pid);	
}

function Delete_Project(pid)
{
	$('#DeleteProject input[name=pid]').val(pid);
}