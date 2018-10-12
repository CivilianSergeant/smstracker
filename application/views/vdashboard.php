<form id="viewReportFrm" method="POST" target="_blank" action="<?php echo BASE.'pdfReport'?>">
<h1>Welcome Dashboard</h1>
<fieldset style="background:#E5E5E5;">
    <legend>View SMS Dispatch Report</legend>

        <?php      
             $user_type = strtolower($user_type);
             if($user_type != "client"){
        ?>
        <!--<p>
            <label>View Option:</label>
            <select name="view_type" style="width:auto;">
                <option value="ALL">ALL</option>
                <option value="SW">School Wise</option> 
            </select>
        </p>-->
        <p>
            <label>Client List</label>
            <select name="client_id" style="width:auto;">
                <option value="">--Select--</option>
                <?php
                    if(!empty($clientList)){
                        
                        foreach($clientList as $client)
                        {
                            echo '<option value="'.$client['clientId'].'">'.ucfirst($client['user_name']).'</option>';
                        }
                    }
                ?>
            </select>
        </p>
        <input type="hidden" name="view_type"  value="Custom" />
        <?php if(!empty($approveSms) && ($SMS_DAY_LIMIT ==1)){ ?>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
        <div style="float:right;background:#cdcdcd;padding:10px;margin-right:15px;">
                <p>
                    <label><?php echo $checkDayLimit ?> SMS Waiting For your approval.</label> 
                </p>
                <p>
                    <a id="approveSms" class="<?php echo $SMS_DAY_LIMIT ?>" style="color:red;" href="<?php echo $approveSms; ?>">Approve</a>
                </p>
        </div>
        <?php }}else{ ?>
            <?php
            
                $totalBalance = (!empty($csms_limit))? array_shift($csms_limit) : array();
                $availableBalance = (!empty($sms_used))? $sms_used : 0;
            ?>
            <p>
            <label>Client List</label>
            <select name="client_id" style="width:auto;">
                <option value="">--Select--</option>
                <?php
                    if(!empty($clientList)){
                      
                        foreach($clientList as $c)
                        {   $userName = strtolower($c['user_name']);
                             $logName = strtolower($this->authenticate->get_user_name());
                            
                            if(count(preg_grep("/$logName/",array($userName)))){
                            echo '<option value="'.$c['clientId'].'">'.ucfirst($c['user_name']).'</option>';
                            } 
                        }
                    }
                ?>
            </select>
        </p>
            <input type="hidden" name="view_type"  value="Client" />
            <!--<div style="float:right;background:#cdcdcd;padding:10px;margin-right:15px;">
            <label>
                <h2>Used Balance: <?php echo ($availableBalance)?$availableBalance:0;?></h2>
                <h2>Total Balance: <?php echo ($totalBalance)?$totalBalance['month_limit']:0;?></h2>
            </label>
            </div>-->
            
        <?php } ?>
        <p id="schools" style="clear:both;">
            <label>School:</label>
            <select name="domain" disabled="disabled">
                <?php 
                if(!empty($domains)){
                    foreach($domains as $domain){
                ?>
                <option value="<?php echo $domain['link']; ?>"><?php echo $domain['name']; ?></option>
                <?php 
                    }
                } ?>
            </select>
        </p>
        <p>
            <label>Report Option:</label>
            <select name="report_option" style="width:auto;">
                <!--<option value="none">None</option>-->
                <option value="today">Today</option>
                <option value="1">From Last day</option>
                <option value="7">From Last 7 days</option>
                <option value="30">From Last 30 days</option>
                <option value="custom">Custom Range</option>
            </select>
            <span id="customDate">
            <label style="text-align:right;width:80px;">Date From</label>
            <input type="text" id="dateFrom" name="dateFrom" disabled="disabled" class="input-medium" />
            <label style="text-align:right;width:50px;">Date To</label>
            <input type="text" id="dateTo" name="dateTo" disabled="disabled" class="input-medium" />
            </span>
        </p>
        <p>
          
            <input type="submit" class="btn-info" name="viewReport" value="View Report"/>
        </p>
        

</fieldset>
<fieldset>
    <legend>&nbsp;</legend>
    <input type="button" id="printBtn" class="btn btn-primary" value="Print" name="printBtn" />
    <input type="submit" id="pdfBtn" class="btn btn-danger" value="PDF" name="pdfBtn" />
    <div id="printArea">
    <table id="reportSummary" class="grid">
        <thead>
            <tr>
                <th colspan="7">&nbsp;</th>
                <th colspan="1" width="150">
<!--                    <input type="button" class="btn-danger" style="margin-top:4px;" value="PDF Download"/>&nbsp;<input type="button" class="btn-success" style="margin-top:4px;" value="CSV Download"/>-->
                </th>
            </tr>
        </thead>
        <thead>
            <?php 
                if($user_type != "client"){
            ?> 
            <tr>
                <th>Sl.</th>
                <th>Masking</th>
                <th>Message Content</th>
                <th>Message Length</th>
                <th>SMS Count</th>
                <th>Date</th>
                <th>Time</th>
                <th>Details</th>
            </tr>
            <?php }else{ ?>
            <tr>
                <th>Sl.</th>
                <th>Masking</th>
                <th>Message Content</th>
                <th>Message Length</th>
                <th>SMS Count</th>
                <th>Date</th>
                <th>Time</th>
                <th>Details</th>
            </tr>
            <?php } ?>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    </div>
</fieldset>
</form>
