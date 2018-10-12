<h1>SMS Credits</h1>
<!--<fieldset class="span5" style="background:#E5E5E5;">
    <legend>Add Balance</legend>
    <form id="smsBalanceFrm">
        <p>
            <label>Provider</label>
            <select name="provider">
                <option value="AIRTEL">Airtel</option>
            </select>
        </p>
        <p>
            <label>Deposite Amount</label>
            <input type="text" style="text-align:right;" name="deposite_amount"/>
        </p>
        <p class="btn_holder">
            <input type="button" class="btn" id="saveBalanceBtn" value="Save"/>
        </p>
    </form>
</fieldset>-->

<fieldset style="min-height:160px;">
    <legend>SMS Balance</legend>
    <h2 class="available_balance">
        Used Balance : <span><?php echo (!empty($usedBalance))? $usedBalance : 0; ?></span>
        <br/>
        <!--Available Balance : <span>50000</span>-->
    </h2>
</fieldset>
<br style="clear:both;"/>
<!--<fieldset style="min-height:160px;">
    <legend><?php echo (!empty($balance))? 'Active Provider - '. ucfirst(strtolower($balance['provider'])) : 'Active Provider'; ?></legend>
    <h2 class="available_balance">
        Available Balance : <span>
    <?php 
        if(!empty($balance))
        {
            echo $balance['balance_available']; 
            if($balance['balance_available']<= REFUND_BALANCE_LIMIT)
            {
                echo '<h2 style="color:#DB2000;">Refund Balance</h2>';
            }
        }
        else
        {
            echo '0.00';
        }
    ?>
        </span>
    </h2>
</fieldset>
<br style="clear:both;"/>-->
<!--<fieldset class="10">
    <legend>Logs</legend>
    <table class="grid">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(!empty($logs)){
                    foreach($logs as $k => $l){
            ?>
            <tr>
                <td style="text-align:center;font-weight:bold;"><?php echo ($k+1); ?></td>
                <?php 
                switch($l['TRANS_STATUS'])
                {
                    case '0':
                        echo '<td style="color:blue;font-weight:bold;">Status Changed</td>';
                        break;
                    case '1':
                        echo '<td style="color:green;font-weight:bold;">New Balance Added</td>';
                        break;
                    case 'D':
                        echo '<td style="color:red;font-weight:bold;">Balance Deducted</td>';
                }
                 ?></td>
                <td style="text-align:center;font-weight:bold;"><?php echo $l['AMOUNT']; ?></td>
                <td style="text-align:center;font-weight:bold;"><?php echo date("d-F,Y", strtotime($l['TRANS_DATE'])); ?></td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    
</fieldset>-->