$(function(){

   $('.Login .submit').click(function(){
        if($('.Login form input[name=card]').val()!=='' && $('.Login form input[name=pass]').val()!=='')
        {
            $('.Login .submit').val('提交中...');
        }
   });

})