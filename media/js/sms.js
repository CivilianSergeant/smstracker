$(function(){
   $("#sms #tabs").tabs(); 
   countMsg1 = $("#singleSmsFrm textarea[maxlength]").val().length;
   countMsg2 = $("#bulkSmsFrm textarea[maxlength]").val().length;
   $("#singleSmsFrm span#countMsg").text(countMsg1);
   $("#bulkSmsFrm span#countMsg").text(countMsg2);
   $("#singleSmsFrm textarea[maxlength]").bind('input propertychange', function() {  
            var maxLength = $(this).attr('maxlength');  
            var countMsg = 0;
            
            checkValidChars($(this));
            
            if ($(this).val().length > maxLength) {  
                $(this).val($(this).val().substring(0, maxLength));  
            } 
            var newCount = countMsg + $(this).val().length;
            var smsCount = 1;
            
                smsCount = ' Sms Count ('+Math.ceil(newCount/160)+')';
            
            $("#single_smsCount").text(smsCount);
            $("#singleSmsFrm span#countMsg").text(newCount);
    });
   $("#bulkSmsFrm textarea[maxlength]").bind('input propertychange', function() {  
            var maxLength = $(this).attr('maxlength');  
            var countMsg = 0;
            
            checkValidChars($(this));
            
            if ($(this).val().length > maxLength) {  
                $(this).val($(this).val().substring(0, maxLength));  
            } 
            var newCount = countMsg + $(this).val().length;
            var smsCount = 1;
            
                smsCount = ' Sms Count ('+Math.ceil(newCount/160)+')';
            
            $("#bulk_smsCount").text(smsCount);
            $("#bulkSmsFrm span#countMsg").text(newCount);
    });
    $("#ss_date").datepicker();
    
    $("#singleSmsFrm input[name=schedule_status],#bulkSmsFrm input[name=schedule_status]").bind("change",function(){
        enableSchedule($(this));
    });
    function enableSchedule(e)
    {
           
           var obj =  e;
           
           if(obj.attr('checked')){
            obj.next().css('display','inline-block').removeAttr('disabled'); //text input
            obj.next().next().css('display','inline-block').children().removeAttr('disabled');
            obj.next().next().next().css('display','inline-block').children().removeAttr('disabled');
            obj.next().next().next().next().css('display','inline-block').children().removeAttr('disabled');

           }else{
            obj.next().css('display','none').attr('disabled','disabled'); //text input
            obj.next().next().css('display','none').children().attr('disabled','disabled');
            obj.next().next().next().css('display','none').children().attr('disabled','disabled');
            obj.next().next().next().next().css('display','none').children().attr('disabled','disabled');
           }
    }
    
    
    enableSchedule($("#singleSmsFrm input[name=schedule_status]"));
    enableSchedule($("#bulkSmsFrm input[name=schedule_status]"));

    function checkValidChars(obj)
    {
        var pattern = /(#|&)/
            
            if(pattern.test(obj.val()))
            {
                obj.val(obj.val().replace(pattern, " "));
                //obj.val(obj.val().substring(0,(obj.val().length-1)));  
                return 1;
            }
            return 0;
    }
    


    $("#singleSmsFrm").submit(function(){
        var obj = $(this);
        
        var number = $("#singleSmsFrm input[name=number]").val();
        var subject = $("#singleSmsFrm select[name=subject]").val();
        var message = $("#singleSmsFrm textarea[name=message]").val();
        var pattern = /\D/;
        if(pattern.test(number)){
            popupMsg('Only Number accepted');
            return false;
        }
        if(number && subject && message){
           
           
           
           var acceptedMessage = checkValidChars($("#singleSmsFrm textarea[name=message]"));
           if(acceptedMessage == 0){
            $.ajax({
                type: "POST",
                url : obj.attr('action'),
                data: obj.serialize(),
                beforeSend:function()
                {
                    $(".success_msg").hide();   
                    $(".error_msg").hide();  
                },
                success:function(e)
                {
                    if(e>0)
                    {
                       $(".success_msg").show();
                       window.location.reload();
                    }
                    else
                    {
                       $(".error_msg").show();      
                    }
                }
            });
           }else{
               popupMsg('Remove Unexpected Character ( #, &) From Message.');
           }
        }else{
            $(".error_msg").show().children('span').text(" Sorry! You cannot send message without number, subject and message");    
        }
       return false; 
    });
    
});

$("#bulkSmsFrm").live('submit',function(){
       
        var obj = $("#bulkSmsFrm textarea[name=message]");
        var pattern = /(#|&)/
            console.log(obj.val());
            
            if(pattern.test(obj.val()))
            {
                popupMsg('Remove Unexpected Character ( #, &) From Message.');
                return false;
            }
            else{
               
                return true;
            }
            
        
});


