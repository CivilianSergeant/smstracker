<fieldset>
    <legend>SMS LIMIT</legend>
    
    <?php 
    
        $client = (!empty($client)) ? array_shift($client): array();
        $clientInfo = (!empty($clientInfo)) ? array_shift($clientInfo) : array();
       
    ?>
    <form id="clientSmsSettingsFrm">
        <p>
            <label><strong>Client Name:</strong></label>
            <strong><?php echo $clientInfo['user_name']; ?></strong>
        </p>
        <?php if(!empty($clientInfo['user_email'])){?>
        <p>
            <label><strong>Client E-mail:</strong></label>
            <strong><?php echo $clientInfo['user_email']; ?></strong>
        </p>
        <?php } ?>
        <p>
            <label><strong>ClientID:</strong></label>
            <strong><?php echo $clientInfo['clientId']; ?></strong>
        </p>
        <p>
            <label><strong>Key:</strong></label>
            <strong><?php echo $clientInfo['key']; ?></strong>
        </p>
        <p>
            <label>Day Limit</label>
            <input type="text" name="day_limit" value="<?php if(isset($client)){ echo $client['day_limit']; }?>"/>
        </p>
        <p>
            <label>Month Limit</label>
            <input type="text" name="month_limit" value="<?php if(isset($client)){ echo $client['month_limit']; }?>"/>
        </p>
        <p>
            <label>&nbsp;</label>
            <input type="hidden" name="client_id" value="<?php echo $client['clientId']; ?>" />
            <input type="button" id="saveSMSLImit" class="btn" value="Save Limit"/>
        </p>
        
    </form>
</fieldset>
<hr/>
<fieldset>
    <legend>Allow Masking</legend>
    <form id="maskingPermission">
    <input type="hidden" name="client_id" value="<?php echo $clientId; ?>"/>
    <table class="grid">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Masking</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
            
                if(!empty($maskings)){
                    foreach($maskings as $k => $masking){
                       
            ?>
            <tr>
                <td><?php echo ($k+1); ?></td>
                <td><?php echo $masking['masking']; ?></td>
                <td>
                    <input type="checkbox" class="makingChange" <?php if(isset($masking['client_masking_id']) && ($masking['client_id'] == $clientId)){ echo 'checked="checked"'; } ?> name="masking" value="<?php echo $masking['maskingId']; ?>"/>
                </td>
            </tr>
            <?php } 
            
                }
            ?>
            
        </tbody>
    </table>
    </form>
</fieldset>