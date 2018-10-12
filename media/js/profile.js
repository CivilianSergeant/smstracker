$(function(){
   
      
   $("#updateUserCredsBtn").click(function(){
       var inputs = $("#updateUserCredsFrm input");
       flag = 1;
       pass = 1;
       
       confirm = 1;
       $.each(inputs,function(i,e){
           var obj = $(this);
           if((obj.hasClass('required')) && (obj.val() == undefined || obj.val() == ""))
           {
               obj.css({'border':'1px solid red'});
               obj.next().text('Required').css({'color':'red'})
               flag = 0;   
           }
           else
           {
               flag=1;
               obj.css({'border':'1px solid #ccc'});
               obj.next().text('');
               if(obj.attr('name') == 'password')
               {
                   if(obj.val().length==8)
                   {
                       obj.next().text('');  
                       pass = 1;
                   }
                   else
                   {
                         obj.next().text('At Least 8 Char').css({'color':'red'}); 
                         pass = 0;  
                   }
               }
               
               if(obj.attr('name') == 'confirmpassword')
               {
    

                   if(obj.val() != $("input[name=password]").val())
                   {
                           obj.next().text('Confirm pass not matched').css({'color':'red'}); 
                           confirm = 0; 
                   }
                   else
                   {    
                           obj.next().text('');  
                           confirm = 1;
                   }
               }
           }
       });
       
       if(flag && pass && confirm)
       {
           $.ajax({
              type:"POST",
              url : BASE + 'dashboard/update_credentials',
              data: $("#updateUserCredsFrm").serialize(),
              success:function(e)
              {
                  if(e == 1)
                  {
                      popupMsg('User Credentials Change Successfully');
                      window.location.reload();
                          
                  }else if(e == 2)
                  {
                      popupMsg('Password and Confirm Password not matched');
                      
                  }else if(e == 0)
                  {
                      popupMsg('Old Password Not Matched');    
                  }
                  
                  
              }
           });
       }
   });
   
});
