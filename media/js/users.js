var progressbar;
var userNameUnique;
$(function(){
   
    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };
    
    $(".refresh_grid").click(function(){
       window.location.reload();
       return false;
    });
   
   //Search User
   $("#searchUserBtn").click(function(){
       var searchTxt = $("input[name=searchTxt]").val();
       var userSearchFrm = $("#searchUserFrm");
       $("#dialogbox").html("");
       $.ajax({
          type:"POST",
          url : BASE + 'dashboard/search_user',
          data: userSearchFrm.serialize(),
          success:function(e)
          {
              var data = $.parseJSON(e);
              
              if(Object.size(data))
              {
                  var user = data['user'];
                  var trHtml = '';
                     $.each(user,function(i,elm){
                        var userName = (user[i].user_name != "")? user[i].user_name : 'No Record Found';
                        var userEmail = (user[i].user_email != "")? user[i].user_email : 'No Record Found';
                        var user_type =  (user[i].user_type != "")? user[i].user_type : 'No Record Found';
                        trHtml += '<tr>'; 
                        trHtml += '<td>'+(i+1)+'</td>'; 
                        trHtml += '<td>'+userName+'</td>'; 
                        trHtml += '<td>'+userEmail+'</td>'; 
                        trHtml += '<td>'+user_type+'</td>'; 
                        trHtml += '<td><a class="user_edit" href="'+user[i].user_id+'">Edit</a> | <a class="user_del" href="'+user[i].user_id+'">Delete</a></td>'; 
                        trHtml += '</tr>'; 
                     });
                  $("table.grid tbody").html(trHtml);
              }
          }
       });
   });
   
   //Create User
   $("#addNewBtn").click(function(){
      $.ajax({
         url: BASE+'dashboard/get_new_user_form',
         success:function(e)
         {
             $("#dialogbox").html(e);
             $("#tabs").tabs();
                progressbar = $( "#progressbar" ),
                progressLabel = $( ".progress-label" );
                progressbar.progressbar({
                    value: true,
                    change: function() {
                        progressLabel.text( progressbar.progressbar( "value" ) + "%" );
                    },
                    complete: function() {
                        progressLabel.text( "Complete!" );
                    }
                });
            $("#date").datepicker();
         }
      });
      $("#dialogbox").dialog({
         modal:true,
         title:'Add New User',
         width:800,
         height: 420
      }); 
   });
   
    function progress() {
        
        var val = progressbar.progressbar( "value" ) || 0;
        progressbar.progressbar( "value", val + 1 );
        if ( val < 100 ) {
            setTimeout( progress, 100 );
        }else{
            
           window.location.reload();
        }
        
    }
    
   //sync user info
//   $("#syncDataBtn").live('click',function(){
//       $.ajax({
//           type:"POST",
//           url : BASE + 'dashboard/sync',
//           beforeSend:function(e)
//           {
//             $("#progressbar").show();  
//           },
//           success:function(e)
//           {
//               if(e != 0)
//               {
//                 setTimeout( progress, 1000 );
//                
//               }else{
//                 popupMsg('File Not Exist');  
//                 window.location.reload();
//               }
//           }
//       });
//       
//   });
   
   
   $("#saveUserBtn").live('click',function(){
       var inputs = $("#addNewUserFrm input,#addNewUserFrm select");
       flag = 1;
       pass = 1;
       email = 1;
       confirm = 1
       $.each(inputs,function(i,e){
           var obj = $(this);
           if((obj.hasClass('required')) && (obj.val() == undefined || obj.val() == ""))
           {
                
                obj.css({'border':'1px solid red'});
                obj.next().text('Required').css({'color':'red'})
                flag = 0;   
           }else{
                obj.css({'border':'1px solid #ccc'});
                obj.next().text('');
                
               if(obj.attr('name') == 'user_email')
               {
                   var pattern = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/
                   
                   if(pattern.test(obj.val()))
                   {
                       obj.next().text('');  
                       email = 1;
                   }
                   else
                   {
                         obj.next().text('Email Not Valid').css({'color':'red'}); 
                         email = 0;  
                   }
               }
               
               
               if(obj.attr('name') == 'password')
               {
                   if(obj.val().length >= 8)
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
    //               console.log($("input[name=password]").val())
    //               console.log(obj.val())

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
       
       if(flag && email && pass && confirm)
       {
          if(userNameUnique){
               $.ajax({
                  type: "POST",
                  url : BASE + 'dashboard/save_user',
                  data: $("#addNewUserFrm").serialize(),
                  success:function(e){
                      popupMsg('User Created')
                      window.location.reload();
                      
                  }
               });
               
          }else{
               popupMsg('User name is not available');
          }
               
       }else{
               popupMsg('Please fillup required fields');
       }
       
   });
   
   //Edit User
   $(".user_edit").live('click',function(){
       var obj = $(this);
       $.ajax({
         type:"POST",
         url : BASE + 'dashboard/get_update_user_form',
         data: {user_id:obj.attr('href')},
         success:function(e)
         {
             $("#dialogbox").html(e);
             
              $("#dialogbox").dialog({
                 modal:true,
                 title:'Edit User',
                 width:800,
                 height:380
               });
         }
       });
       return false;  
   });
   
   //Update User
   $("#updateUserBtn").live('click',function(){
       $.ajax({
          type:"POST",
          url : BASE + 'dashboard/update_user',
          data: $("#updateUserFrm").serialize(),
          success:function(e)
          {
              popupMsg('User updated successfully');
              window.location.reload();
          }
       });
   });
   
   //Delete User
   $(".user_del").click(function(){
      $("#dialogbox").html("Are you sure to delete this user's data");
      var obj = $(this);
      $("#dialogbox").dialog({
         modal:true,
         title:'Warning !',
         width:400,
         height:150,
         buttons:{
             'Yes':function(){
                 
                 $.ajax({
                    type:"POST",
                    url : BASE + 'dashboard/delete_user',
                    data: {user_id:obj.attr('href')},
                    success:function(e){
                        $("#dialogbox").remove();
                        obj.parent().parent().remove();
                        window.location.reload();
                    }
                 });
             },
             'No':function(){
                $( this ).dialog( "close" );
                window.location.reload();
             }
         }
      });
      return false;
   });
   
   $("input[name=user_name]").live('blur',function(){
      var obj = $(this);
      $.ajax({
        type:"POST",
        url : BASE + 'dashboard/unique_user_name',
        data: {user_name:obj.val()},
        success:function(e)
        {
            if(e == 1)
            {
               userNameUnique = 0;
               popupMsg('User name should be unique'); 
            }else{
               userNameUnique = 1;
            }  
        }
      }); 
      
   });
   
     
});