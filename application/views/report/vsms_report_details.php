<h1>Welcome Dashboard</h1>
<fieldset style="background:#E5E5E5;">
    <legend>View Detail Report for <?php echo $result['Link'];?> - [<?php echo $reportOf; ?>]</legend>
    <table class="grid">
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Queue Id</th>
                <th>Job Id</th>
                <th>Phone Number</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
       
    <?php 

    $resultObj = ($result['Details']);
    if(is_object($resultObj) && (!empty($resultObj->result)))
    {
        foreach($resultObj->result as $k => $r)
        {
    ?>
         <tr>
            <td><?php echo ($k+1); ?></td>
            <td><?php echo $r->queue_id; ?></td>
            <td><?php echo $r->job_id; ?></td>
            <td><?php echo $r->phone_no; ?></td>
            <td><?php echo urldecode($r->msg); ?></td>
            <td><?php echo (empty($r->timestamp) || $r->timestamp==null)? $r->datetime: $r->timestamp; ?></td>
        </tr>   
    <?php
        }
        
    }
    ?>
         
        </tbody>
    </table>        
</fieldset>