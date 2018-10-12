<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SMS Tracker | Dashboard</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="<?php echo CSS.'bootstrap.min.css'; ?>" rel="stylesheet" media="all"/>
        <link href="<?php echo CSS.'bootstrap-responsive.min.css'; ?>" rel="stylesheet" media="all"/>
        <link href="<?php echo CSS.'redmond/jquery-ui-1.8.16.custom.css'; ?>" rel="stylesheet" media="all"/>
        
        <link href="<?php echo CSS.'layout.css'; ?>" rel="stylesheet" media="all"/>
        <script src="<?php echo JS.'jquery.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo JS.'jquery-ui-1.8.16.custom.min.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo JS.'layout.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo JS.$script.'.js'; ?>" type="text/javascript"></script>
        <!--[if IE 9]> <script src="<?php JS.'html5.js'; ?>" type="text/javascript"></script> <![endif]-->
        <script type="text/javascript">
           var BASE = "<?php echo BASE; ?>";
           var IMAGE = "<?php echo IMAGE; ?>";
           function msgReposition()
           {
               var screenWidth = window.screen.width;
               var msgWidth = $("#msg").width();
               $("#msg").css('left',(screenWidth-msgWidth)/2);
           }
           
        </script>
    </head>
    <body>
        
        <div id="wrapper" class="row-fluid">
            <div id="notificationBar">
                <h1>SMS Tracker</h1>
                <span>
                    <?php if($balance['balance_available'] <= REFUND_BALANCE_LIMIT){ ?>
                    <a style="color:red;">Refund Balance</a>
                    <?php } ?>&nbsp;<a>Welcome,<a> <a href="<?php echo BASE.'dashboard/profile'; ?>"><?php echo ucfirst($this->authenticate->get_user_name()); ?></a>
                            <a>|</a> <a href="<?php echo BASE.'login/logout'; ?>">Logout</a>
                </span>
            </div>
            <aside class="span2">
                <nav>
                    <ul>
                        <li><a href="<?php echo BASE.'dashboard'; ?>"><img src="<?php echo IMAGE.'doc_lines_stright_icon48.png';?>"/>Dashboard</a></li>
                        <?php 
                        $user_type = $this->authenticate->get_user_type();
                        if(strtolower($user_type) != 'client'){
                        ?> 
                        <li><a href="<?php echo BASE.'dashboard/users';?>"><img src="<?php echo IMAGE.'user_icon48.png'; ?>"/>Users</a></li>
                        <li><a href="<?php echo BASE.'credits/';?>"><img src="<?php echo IMAGE.'spechbubble48.png'; ?>"/>SMS Credits</a></li>
<!--                        <li><a href="<?php echo BASE.'limits/';?>"><img src="<?php echo IMAGE.'spechbubble48.png'; ?>"/>SMS Limit</a></li>-->
                        <li><a href="<?php echo BASE.'dashboard/maskings';?>"><img src="<?php echo IMAGE.'cog_icon48.png'; ?>"/>Maskings</a></li>
                        <li><a href="<?php echo BASE.'line';?>"><img src="<?php echo IMAGE.'cog_icon48.png'; ?>"/>Line Settings</a></li>
                        <li><a href="<?php echo BASE.'dashboard/settings';?>"><img src="<?php echo IMAGE.'cog_icon48.png'; ?>"/>Settings</a></li>
                        <li>
                            <a href="<?php echo BASE.'dashboard/sms';?>"><img src="<?php echo IMAGE.'spechbubble48.png'; ?>"/>SMS</a>
                        </li>
                        <?php }
                        //else{ ?>
                      
                        
                        <?php // } ?>
                    </ul>
                </nav>
            </aside>
            <div class="span10" id="content">
                <?php echo (!empty($content))? $content:''; ?>
            </div>
        </div>
        <div id="msg">
            Loading...
        </div>
        <div id="dialogbox">
            
        </div>
    </body>
    <script type="text/javascript">
        $(function(){
            window.onload = msgReposition;
            window.onresize = msgReposition;
        });
        
            
    </script>
</html>
