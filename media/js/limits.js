$(function(){
   $('.insertSMSL').click(function(){
      var obj = $(this);
      var schoolId = obj.parent().prev().prev().prev().children().val();
      var numStud = obj.parent().prev().prev().children().val();
      var smsLimit = obj.parent().prev().children().val();
      var domain_id = obj.attr('href');
      $.ajax({
          type: "POST",
          url : BASE + 'limits/save_limit',
          data: {num_stud:numStud,limit:smsLimit,schoolId:schoolId,domainID:domain_id},
          success:function(e)
          {
              window.location.reload();
          }
      }); 
      return false; 
   }); 
   
   $('.updateSMSL').click(function(){
      var obj = $(this);
      var numStud = obj.parent().prev().prev().children().val();
      var smsLimit = obj.parent().prev().children().val();
      $.ajax({
          type: "POST",
          url : BASE + 'limits/save_limit',
          data: {num_stud:numStud,limit:smsLimit},
          success:function(e)
          {
              window.location.reload();
          }
      }); 
      return false; 
   }); 
   
   $(".makingChange").change(function(){
      var obj = $(this);
      if(obj.attr('checked') == 'checked')
      {
          $.ajax({
             type:"POST",
             url : BASE+'limits/save_client_masking',
             data: {client_id:$("input[name=client_id]").val(),masking:obj.val()},
             success:function(e)
             {
                 
             }
          });   
      }else{
          $.ajax({
             type:"POST",
             url : BASE+'limits/update_client_masking',
             data: {client_id:$("input[name=client_id]").val(),masking:obj.val()},
             success:function(e)
             {
                 
             }
          });
      }
   });
   
   $("#saveSMSLImit").click(function(){
       var obj =  $(this);
       
       $.ajax({
          type: "POST",
          url : BASE+'sms_limit/save_sms_limit',
          data: $("#clientSmsSettingsFrm").serialize(),
          success:function(e)
          {
              popupMsg('SMS Limit Updated');
          }
       });
   });
});