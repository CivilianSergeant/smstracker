<style>
    <!--
    #header{ text-align:center; line-height:30px; margin-bottom:10px;}
    #header h2,#header h3{padding:0px; margin:0px;}
    table#PersonInfo{border:1px solid #000; }
    table#attendanceList{border:1px solid #000;}
    table#attendanceList thead th{padding:6px;}
    table#attendanceList tbody td{ text-align:center;border-bottom:1px solid #000;border-right:1px solid #000;}
    table#times tr td{border-bottom:1px solid #000;}
    table#times tr td:last-child{border-bottom:none !important;}
    -->
</style>
<div id="header">
    <h3>BBC Media Action</h3>
    <h3>IK Tower (7th Floor), CEN (A) 2, Gulshan Avenue</h3>
    <h3>Gulshan-2, Dhaka-1212</h3>
    <h2><u>Detailed Employee TimeSheet</u></h2>

</div>
<table id="PersonInfo">
    <tr>
        <td style="width:150px;text-align:right;">Employee:</td>
        <td style="width:250px;text-align:left;"><strong><?php echo $employee['name'].'(#'.$employee['emp_card_id'].')'; ?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:150px;text-align:right;">Pay Period:</td>
        <td style="width:160px;text-align:left;"><strong>N/A</strong></td>
    </tr>
    <tr>
        <td style="width:150px;text-align:right;">Title:</td>
        <td style="width:250px;text-align:left;"><?php echo $employee['title']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:150px;text-align:right;">Branch:</td>
        <td style="width:160px;text-align:left;"><?php echo $employee['office_name']; ?></td>
    </tr>
    <tr>
        <td style="width:150px;text-align:right;">Duration:</td>
        <td style="width:250px;text-align:left;"><?php echo $dateFrom.' - '.$dateTo; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:150px;text-align:right;">Department:</td>
        <td style="width:160px;text-align:left;"><?php echo $employee['department_name']; ?></td>
    </tr>
</table>  
<table id="attendanceList" cellspacing="0" cellpadding="0"style="margin-top:10px;">
    <thead>
        <tr>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">#</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">Date</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">DoW</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">In</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">Out</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">Worked Time</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">Regular Time</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">&nbsp;</th>
            <th style="width:50px;background:#ccc; text-align:center; border-right:1px solid #000; border-bottom:1px solid #000;">&nbsp;</th>
            <th style="width:45px;background:#ccc; text-align:center; border-bottom:1px solid #000;">&nbsp;</th>
        </tr>
    
    </thead>
    <tbody>
        <?php
        if(!empty($report)){
            $h = 0;$m=0; $hrs =0; $min=0; $timeExplode='';
            foreach($report as $k => $r)
            {
        ?>
        <tr>
            <td>#</td>
            <td><?php echo $k; ?></td>
            <td><?php echo date("D",strtotime($k)); ?></td>
            <td style="text-align:left;padding:0px; margin:0px;">
                <?php
                if(!empty($r['IN'])){
                ?>
                <table class="times" cellspacing="0" border="0" cellpadding="0">
                    <?php 
                    foreach($r['IN'] as $j=> $in){
                    ?>
                    <tr><td style="<?php if($j== count($r['IN'])-1){ echo 'border:0px;';} ?> width:100%; display:block; border-right:none;"><?php echo $in; ?></td></tr>
                    <?php } ?>
                </table>
                <?php
                }
                ?>
            </td>
            <td style="text-align:center;">
                <?php
                if(!empty($r['OUT'])){
                ?>
                <table class="times" cellspacing="0" cellpadding="0">
                    <?php 
                    foreach($r['OUT'] as $k => $out){
                    ?>
                    <tr>
                        <td style=" <?php if($k== count($r['OUT'])-1){ echo 'border:0px;';} ?> width:100%; display:block; border-right:none;">
                        <?php echo $out; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <?php
                }
                ?>
            </td>
            <td style="font-size:12px; font-weight:bold;"><?php $timeExplode = explode(":",$r['WT'][0]); echo $r['WT'][0]; ?></td>
            <td><?php echo $regular_time['value']; ?></td>
        </tr>
        <?php 
                $hrs += $timeExplode[0];
                $min += $timeExplode[1];
            }
            $h = $hrs;
            if(($min%60) != 0)
            {
                $h += round($min/60);
                $m = ($min%60);
            }
        }
        ?>
    </tbody>
    
</table>
<table>
        <tr>
            <td><strong>Total Time:</strong></td> 
            <td><strong><?php echo $h.'hrs '.$m.'min'; ?></strong></td>
        </tr>
    </table>
<div style="margin-top:10px;font-size:14px;">
    <strong>By signing this timesheet I hereby certify that the above time accurately and fully reflects the time that <?php echo $employee['name']; ?> worked during the
    designated period.</strong>
</div>
      
<div id="footerContent" style="margin-top:30px;">
    <table>
        <tr>
            <td>Employee :</td>
            <td style="border-top:1px solid #000;padding-right:50px;padding-left:50px;"><span style="border-top:1px solid #000;display:block;width:100px; margin-top:10px;text-align:center;">Jahidur Rahman</span></td>
            
            <td style="width:200px;text-align:right;"><span>Supervisor Signature :</span></td>
            <td style="border-top:1px solid #000;padding-right:50px;padding-left:50px;"><span style="border-top:1px solid #000;display:block;width:100px; margin-top:10px;">(print name)</span></td>
        </tr>
    </table>
</div>
<page>
  <page_footer>
<div style="margin-top:10px;font-size:14px;">
    <strong>By signing this timesheet I hereby certify that the above time accurately and fully reflects the time that Jahidur Rahman worked during the
    designated period.</strong>
</div>
      
<div id="footerContent" style="margin-top:30px;">
    <table>
        <tr>
            <td>Employee :</td>
            <td style="border-top:1px solid #000;padding-right:50px;padding-left:50px;"><span style="border-top:1px solid #000;display:block;width:100px; margin-top:10px;text-align:center;">Jahidur Rahman</span></td>
            
            <td style="width:200px;text-align:right;"><span>Supervisor Signature :</span></td>
            <td style="border-top:1px solid #000;padding-right:50px;padding-left:50px;"><span style="border-top:1px solid #000;display:block;width:100px; margin-top:10px;">(print name)</span></td>
        </tr>
    </table>
</div>
    [[page_cu]]/[[page_nb]]   
  </page_footer>
</page>
