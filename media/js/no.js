$(function(){
    $("#dateFrom,#dateTo").datepicker({changeYear: true,changeMonth:true});
    
    $("select[name=view_type]").change(function(){
       var obj = $(this);
       if(obj.val() == "SW")
       {
           $("#schools").find('select').removeAttr('disabled');
           $("#schools").show();
       }
       else
       {
           $("#schools").find('select').attr('disabled','disabled');
           $("#schools").hide();    
       }
    });
    var report_option = $("select[name=report_option]").val();
    
    if(report_option == "custom"){
        $("#customDate").find('input').removeAttr('disabled');
        $("#customDate").show();
    }else{
        $("#customDate").find('input').attr('disabled','disabled');
        $("#customDate").hide(); 
    }
    $("select[name=report_option]").change(function(){
       var obj = $(this);
       if(obj.val() == "custom")
       {
           $("#customDate").find('input').removeAttr('disabled');
           $("#customDate").show();
       }else
       {
           $("#customDate").find('input').attr('disabled','disabled');
           $("#customDate").hide();  
       }
    });
    
    $("input[name=viewReport]").click(function(){
        var obj = $('#viewReportFrm');
        $.ajax({
           type:"POST",
           url : BASE + 'service/get_report',
           data: obj.serialize(),
           beforeSend:function(){
               $("#reportSummary tbody").html('<tr><td colspan="8" style="text-align:center;font-size:14px;font-weight:bold;"><img src="'+IMAGE+'486.gif" alt="Loading..."/></td></tr>');
           },
           success:function(e)
           {
               $("#reportSummary tbody").html(e);
           }
        });
        return false;
    });
    
    $(".viewDetails").live('click',function(){
        var obj = $(this);
        $.ajax({
           type:"POST",
           url : BASE + 'service/get_details',
           data:  $("#viewReportFrm").serialize()+'&domain='+obj.attr('href'),
           beforeSend:function()
           {
               $("#msg").html('<img src="'+IMAGE+'486.gif" alt="Loading..."/>');
               $("#msg").show();
           },
           success:function(e)
           {
                $("#msg").html('').hide();
                var DocumentContainer = e;
                var WindowObject = window.open('', '_blank');
                WindowObject.document.writeln(DocumentContainer);
                WindowObject.document.close();
                WindowObject.focus();
           }
           
        });
                
        return false; 
    });
    
    $(".view_details").live('click',function(){
        var obj = $(this);
        var clientId = obj.attr('data-client_id');
        var date = obj.attr('data-date');
        var masking = obj.attr('data-masking');
        $.ajax({
           type: "POST",
           url : BASE + 'service/get_client_details',
           data:{client_id:clientId,date:date,masking:masking},
           beforeSend:function(e){
               $("#dialogbox").hide();
               $("#dialogbox").html("");
               popupMsg('Loading Pleas Wait');
           },
           success:function(e)
           {
               $("#dialogbox").html(e);
               $("#dialogbox").dialog({
                 modal:true,
                 title:'SMS Details Report',
                 width:800,
                 height: 420
              });
              $("#dialogbox").show();
           }
        });
        return false; 
    });
    
    $("#approveSms").click(function(){
       var obj = $(this);
       if(confirm("Are you sure?")){
           $.ajax({
               type:"POST",
               url : obj.attr('href'),
               data: {'user_id': $("input[name=user_id]").val()},
               success:function(e){

               }
           }); 
       }
    });


    $("#printBtn").click(function(){
        var printContent = $("#printArea").html();
        var styleElm = '<link href="'+BASE+'media/css/layout.css" rel="stylesheet" media="all"/><style>body{background:#fff;}strong{border-left:1px;}table#reportSummary{width:98%; margin:10px;} table tr th:last-child,table tr td:last-child{display:none;}h1{ margin:10px;}</style>';
        var client = $("select[name=client_id] option:selected").text();
        var reportOption = $("select[name=report_option] option:selected").text();
        var duration = reportOption;

        if($("select[name=report_option] option:selected").val() == 'custom')
            duration = $("#dateFrom").val() + " - " + $("#dateTo").val();
        var titleElm = '<h1>Report of '+client+', Report Period : '+duration+'</h1>';
        var DocumentContainer = printContent;
        var WindowObject = window.open('', '_blank');
        WindowObject.document.writeln(styleElm);
        WindowObject.document.writeln(titleElm+DocumentContainer);
        WindowObject.document.close();
        WindowObject.focus();
    });

});




