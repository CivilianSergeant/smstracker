<?php
/**
 * Description of cron
 *
 * @author Himel
 */
class Cron extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('mservices');
        $this->load->model('msms_balance');
        $this->load->model('msettings');
        $this->load->model('mbalance_deducted');
    }
    
    public function index()
    {
        date_default_timezone_set('Asia/Dhaka');
        $reports = $this->mservices->get_report_summary('','today');
        
        $totalSMSCount = 0;
        if(!empty($reports))
        {
            
            foreach($reports as $r)
            {
                if($r['Status'] == 200)
                {
                    $countObj = $r["Count"];
                    $totalSMSCount += $countObj->result;
                }
            }
            
            $activeBalance = $this->msms_balance->tbl_get(array('balance_status'=>1));
            $activeBalance = (!empty($activeBalance))? array_shift($activeBalance): array();
            $deductedBalance = $availableBalance = $activeBalance['balance_available'] - $totalSMSCount;
            
            
            $this->db->trans_start();
    
            //update available balance
            $this->msms_balance->tbl_update(array(
                'balance_available'=>$deductedBalance,
            ),array('sms_balance_id'=>$activeBalance['sms_balance_id']));
            
            // add history of balance deduction
            $this->mbalance_deducted->save(array(
                'amount_deducted' => $totalSMSCount,
                'deduction_status' => 'D',
                'transaction_dt'  => date("Y-m-d H:i:s")
            ));
            
            $settings = $this->msettings->get_settings(array('key'=>'email'));
            if(!empty($settings))
            {
                $to = $settings['value'];
                $subject = 'SMS Deducted';
                $headers = 'From: no-reply@bengalsols.com';
                //mail($to,$subject, $totalSMSCount.' sms balance deducted today',$headers);
                
                
            }
            $this->db->trans_complete();
        }
    }
    
}

?>
