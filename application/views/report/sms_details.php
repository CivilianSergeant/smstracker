<fieldset>
    <?php 
        
       $info = (!empty($clientInfo))? array_shift($clientInfo) : array();
    ?>
    <legend>SMS Details - <?php echo $date; ?></legend>
    <table class="grid">
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Phone Number</th>
                <th>Message</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(!empty($result)){
                    foreach($result as $k=> $r){
            ?>
            <tr>
                <td><?php echo ($k+1); ?></td>
                <td><?php echo $r['number']; ?></td>
                <td style="width:200px !important;"><?php echo urldecode($r['message']); ?></td>
                <td><?php echo $r['dispatch_dt']; ?></td>
                <td><?php echo $r['dispatch_time'];?></td>
            </tr>
            <?php
                    }
            
            } ?>
        </tbody>
    </table>
</fieldset>