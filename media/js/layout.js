//media/js/layout.js

    
    
    function popupMsg($msg)
    { 
        $msg = ($msg != undefined)? $msg : 'Loading...';
        $("#msg").text($msg);
        msgReposition();
        if($("#msg").css('display') != 'none')
            $("#msg").delay(1500).fadeOut('fast');
        else
            $("#msg").fadeIn().delay(1500).fadeOut('fast');
    }
    
    

