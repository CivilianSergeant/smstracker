// media/js/settings.js
$(function(){
   
   $("#saveDomainBtn").click(function(){
       $.ajax({
          type: "POST",
          url : BASE + 'dashboard/save_domain',
          data: $("#addDomainFrm").serialize(),
          success:function(e)
          {
              popupMsg("Domain Added");
              window.location.reload();
              $("input[name=name]").val('');
              $("input[name=link]").val('');
          }
       });
   });
   
   $(".domain_edit").click(function(){
    var obj = $(this);
    $.ajax({
       type:"POST",
       url : BASE + 'dashboard/get_domain_edit_form',
       data: {domain_id:obj.attr('href')},
       success:function(e)
       {
           $("#dialogbox").html(e);
           $("#dialogbox").dialog({
              modal: true,
              title: 'Edit Domain',
              resizable:false,
              width:500,
              height:300
           });
       } 
    });
    return false;
   });
   
   $("#updateDomainBtn").live('click',function(){
      $.ajax({
          type: "POST",
          url : BASE + 'dashboard/update_domain',
          data: $("#updateDomainFrm").serialize(),
          success:function(e)
          {
              popupMsg("Domain Updated");
              window.location.reload();
          }
       });
   });
   
   $("input#notifyEmailBtn").click(function(){
      var obj = $(this);
      var sValue = $("input[name=email]").val();
      $.ajax({
          type:"POST",
          url : BASE + 'dashboard/update_settings',
          data: $("#notifyEmailFrm").serialize(),
          beforeSend:function()
          {
              popupMsg('Updating...')
              obj.attr('disabled','disabled');
          },
          success:function(e)
          {
               popupMsg('Settings Updated.')
               obj.removeAttr('disabled');
          }
      });
   });
   
   
   $(".domain_generate").click(function(){
      var obj = $(this);
      $.ajax({
         type: "POST",
         url : BASE + 'dashboard/regenerate_apikey',
         data: {domain_id:obj.attr('href')},
         success:function(e)
         {
             
         }
      });
      
      return false;
   });

   $(".domain_del").click(function(){
       
       var obj = $(this);
       if(confirm('Are you sure to delete this record ?'))
       {
           $.ajax({
              type:"POST",
              url : BASE + 'dashboard/domain_del',
              data: {domain_id:obj.attr('href')},
              success:function(e)
              {
                  obj.parent().parent().remove();
              }
           });
       }
       return false;
   });
    
});