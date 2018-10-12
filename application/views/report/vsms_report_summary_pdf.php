<page>

    <?php
    $duration = '';
    if($report_option == 'custom'){
        $duration = $date_from.'-'.$date_to;
    }elseif($report_option == 2){
        $duration = 'Last Day';
    }
    elseif($report_option > 2)
    {
        $duration = 'Last '. $report_option .' days';
    }else{
        $duration = $report_option;
    }
    ?>
    <h1>SMS Report of <?php echo $duration; ?></h1>
    <table style="width:100%;font-size:13px;" cellspacing="0" cellpadding="0">
        <thead>
            <tr style="background:#ababab;text-align:center;">
                <th style="width:12.5%">Sl.</th>
                <th style="width:12.5%">Masking</th>
                <th style="width:25%">Message Content</th>
                <th style="width:12.5%">Message Length</th>
                <th style="width:12.5%">SMS Count</th>
                <th style="width:12.5%">Date</th>
                <th style="width:12.5%">Time</th>

            </tr>
        </thead>
<?php
//echo $user_type;

if(!empty($result))
{
?>
<tbody>
<?php
    if(strtolower($user_type) != 'client'){
    $i = 0;
    $totalCount = 0;
    foreach($result['result'] as $key=> $rs){ $i++;
?>

<tr <?php if(($i%2)==0) echo 'style="background:#DDDDDD;"'; ?>>
    <td style="width:12%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $i; ?></td>
    <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['masking']; ?></td>
    <td style="width:25%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo str_replace('\n',"<br/>",urldecode($rs['messageContent'])); ?></td>
    <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['messageLen']; ?></td>
    <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['numSmsCount']; $totalCount += $rs['numSmsCount']; ?></td>
    <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['date']; ?></td>
    <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;border-right:1px solid #777;"><?php echo $rs['time']; ?></td>

</tr>

<?php } ?>
<tr>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
    <td style="width:25%;border-left:1px solid #777;border-bottom:1px solid #777;"></td>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;"><strong>Total</strong></td>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;"><strong><?php echo $totalCount; ?></strong></td>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
    <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;border-right:1px solid #777;">&nbsp;</td>

</tr>
<?php 
    }else{ 
        $i=0;
        $totalCount = 0;
        foreach($result['result'] as $key=> $rs){ $i++;
?>

            <tr>
                <td style="width:12%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $i; ?></td>
                <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['masking']; ?></td>
                <td style="width:25%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo str_replace('\n',"<br/>",urldecode($rs['messageContent'])); ?></td>
                <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['messageLen']; ?></td>
                <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['numSmsCount']; $totalCount += $rs['numSmsCount']; ?></td>
                <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;"><?php echo $rs['date']; ?></td>
                <td style="width:12.5%;text-align:center;border-left:1px solid #777;border-bottom:1px solid #777;border-right:1px solid #777;"><?php echo $rs['time']; ?></td>

            </tr>
<?php
        }
?>
        <tr>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
            <td style="width:25%;border-left:1px solid #777;border-bottom:1px solid #777;"></td>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;"><strong>Total</strong></td>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;"><strong><?php echo $totalCount; ?></strong></td>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;">&nbsp;</td>
            <td style="width:12.5%;border-left:1px solid #777;border-bottom:1px solid #777;border-right:1px solid #777;">&nbsp;</td>

        </tr>
<?php
    }
?>
</tbody>
<?php
}
?>
    </table>
    <page_footer>
        [[page_cu]]/[[page_nb]]
    </page_footer>
</page>