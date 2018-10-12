<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SMS Tracker|Login</title>
        <link href="<?php echo CSS.'styles.css';?>" rel="stylesheet" media="all"/>
        <script src="<?php echo JS.'jquery.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo JS.'layout.js'; ?>" type="text/javascript"></script>
        <script type="text/javascript">
           var BASE = "<?php echo BASE; ?>";
           function msgReposition()
           {
               var screenWidth = window.screen.width;
               var msgWidth = $("#msg").width();
               $("#msg").css('left',(screenWidth-msgWidth)/2);
           }
           
        </script>
    </head>
    <body>
        <form id="loginFrm" action="<?php echo BASE.'login'?>" method="POST">
            <h1>Login</h1>
            <hr/>
            <p>
                <label>User ID</label>
                <input type="text" name="username"/>
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="password"/>
            </p>
            <p>
                <input class="btn" type="submit" name="login" value="Login"/>
            </p>
        </form>
        <div id="msg">
            Loading...
        </div>
    </body>
    
    <script type="text/javascript">
        $(function(){
            $("#loginFrm").submit(function(){
               $.ajax({
                  type:"POST",
                  url : "<?php echo BASE.'login';?>",
                  data: $(this).serialize(),
                  success:function(e)
                  {
                      var data = $.parseJSON(e);
                      if(data.status)
                      {
                         popupMsg('Login Successfully');  
                         window.location = data.loc;
                      }
                      else
                      {
                          popupMsg('Login failed');  
                          window.location = data.loc;    
                      }
                  }
               }); 
               return false;
            });
        });
    </script>
</html>
