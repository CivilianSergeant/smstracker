$(function(){
    
    $("#saveBalanceBtn").click(function(){
        
        $.ajax({
           type:"POST",
           url : BASE + 'credits/save_balance',
           data: $("#smsBalanceFrm").serialize(),
           success:function(e)
           {
               popupMsg("Balance Added Successfully");
               window.location = BASE+'credits';
           }
           
        });
    });
    
});