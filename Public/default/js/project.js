function Modify_Project(pid,pname,pdesc,cid)
{
	$('#ChangeData input[name=pname]').val(pname);	
	$('#ChangeData textarea[name=pdesc]').val(pdesc);	
	$('#ChangeData input[name=pid]').val(pid);
    if(cid)
    {
        $('#ChangeData select option').each(function () {
            if ($(this).val() == cid)
            {
                $(this).attr('selected', 'selected');
            }
        });
    }
}

function Delete_Project(pid)
{
	$('#DeleteProject input[name=pid]').val(pid);
}