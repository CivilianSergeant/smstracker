<fieldset>
    <legend>Student SMS LIMIT</legend>
    <table class="grid">

    <thead>
        <tr>
            <th>Name</th>
            <th>Student Count</th>
            <th>SMS Limit</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        
    
<?php 


if(!empty($limits))
{
    $output = '';
    foreach($limits as $limit)
    {
        
        $countObj = (!empty($limit['studentsCount']))? json_decode($limit['studentsCount']) : "";
        $numberOfStudent = (!empty($countObj))? $countObj->result:'';
        $smsLimit = (!empty($limit['schoolInfo']['sms_limit']))? $limit['schoolInfo']['sms_limit'] : DEFAULT_SMS_LIMIT;
        
        
        $linkLen = $limit['schoolInfo']['link'];
        $output .= '<tr>';
        $output .= '<td><input type="hidden" value="'.substr($limit['schoolInfo']['link'],0,$linkLen-8).'"/>'.$limit['schoolInfo']['name'].'</td>';
        $output .= '<td><input type="hidden" value="'.$numberOfStudent.'"/>'.$numberOfStudent.'</td>';
        $output .= '<td><input type="text" class="input-mini" name="sms_limit" value="'.$smsLimit.'"/></td>';
        $output .= '<td>';
        if(!empty($limit['schoolInfo']['sms_limit_id']))
            $output .= '<a class="updateSMSL" href="#">Update</a>';
        else
            $output .= '<a class="insertSMSL" href="'.$limit['schoolInfo']['did'].'">Add</a>';
        $output .= '</td>';
        $output .='</tr>';
    }
    echo $output;
}
?>
        </tbody>
</table>
</fieldset>