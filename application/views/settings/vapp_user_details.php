<?php 
    $name = (!empty($domain))? $domain['name'] : '';
    $clientId = (!empty($domain))? $domain['clientId'] : '';
    $key = (!empty($domain))? $domain['key']: '';
    $link = (!empty($domain))? $domain['link']: '';
?>
<h1>Details of <?php echo $name; ?></h1>
<fieldset>
    
    <p>
        <label><strong>Name</strong></label>
        <span><?php echo $name; ?></span>
    </p>
<!--    <p>
        <label><strong>Username</strong></label>
        <span></span>
    </p>
    <p>
        <label><strong>Password</strong></label>
        <span></span>
    </p>-->
    <p>
        <label><strong>Link</strong></label>
        <span><?php echo $link; ?></span>
    </p>
    <p>
        <label><strong>Client ID</strong></label>
        <span><?php echo $clientId; ?></span>
    </p>
    
    <p>
        <label><strong>Api Key</strong></label>
        <span><?php echo $key; ?></span>
    </p>
<!--    <form id="updateAppUserInfo">
        
    </form>-->
</fieldset>