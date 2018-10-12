<?php
//echo $user_type;

if(!empty($result))
{
    
    if(strtolower($user_type) != 'client'){
    $i = 0;
    $totalCount = 0;
    foreach($result['result'] as $key=> $rs){ $i++;
?>

<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $rs['masking']; ?></td>
    <td style="width:200px !important;"><?php echo urldecode($rs['messageContent']); ?></td>
    <td><?php echo $rs['messageLen']; ?></td>
    <td><?php echo $rs['numSmsCount']; $totalCount += $rs['numSmsCount']; ?></td>
    <td><?php echo $rs['date']; ?></td>
    <td><?php echo $rs['time']; ?></td>
    <td><a class="view_details" data-client_id="<?php echo $rs['clientId']; ?>" data-date="<?php echo $rs['date']; ?>" data-masking="<?php echo $rs['masking']; ?>" href="#">View Details</a></td>
</tr>

<?php } ?>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:200px !important;"></td>
    <td><strong>Total</strong></td>
    <td><strong><?php echo $totalCount; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<?php 
    }else{ 
        $i=0;
        $totalCount = 0;
        foreach($result['result'] as $key=> $rs){ $i++;
?>

<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $rs['masking']; ?></td>
    <td style="width:200px !important;"><?php echo urldecode($rs['messageContent']); ?></td>
    <td><?php echo $rs['messageLen']; ?></td>
    <td><?php echo $rs['numSmsCount']; $totalCount += $rs['numSmsCount'];  ?></td>
    <td><?php echo $rs['date']; ?></td>
    <td><?php echo $rs['time']; ?></td>
    <td><a class="view_details" data-client_id="<?php echo $rs['clientId']; ?>" data-date="<?php echo $rs['date']; ?>" data-masking="<?php echo $rs['masking']; ?>" href="#">View Details</a></td>
</tr>
<?php
        }
?>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:200px !important;"></td>
    <td><strong>Total</strong></td>
    <td><strong><?php echo $totalCount; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<?php
    }
}
?>