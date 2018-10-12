<?php
/**
 * Description of reports
 *
 * @author Himel
 */
class Reports extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mdb');
        $this->load->model('memployees');
        $this->load->model('msettings');
        
    }
    
    public function index()
    {
        
        $dateFrom = date('Ymd',strtotime($this->input->post('dateFrom')));
        $dateTo = date('Ymd',strtotime($this->input->post('dateTo')));
        
        $C_Card = $this->input->post('card_id');
        
        $stmt = "SELECT * FROM tEnter WHERE C_Card = '{$C_Card}' AND (L_TID = 1 OR L_TID = 3 OR L_TID = 4 OR L_TID = 5)AND (C_Date BETWEEN '".$dateFrom."' AND '".$dateTo."')";
        $stmt1 = "SELECT * FROM tEnter WHERE C_Card = '{$C_Card}' AND (L_TID = 2 OR L_TID = 6)AND (C_Date BETWEEN '".$dateFrom."' AND '".$dateTo."')";
        
        $intimes = $this->mdb->getIntimes($stmt);
        $outtimes = $this->mdb->getOuttimes($stmt1);
        $employee = $this->memployees->get_employee_by_card($C_Card);
        $inTime = array();
        $outTime = array();
        if(!empty($employee)){
        $workdate = '';
        if(!empty($intimes))
        {
            foreach($outtimes as $time)
            {
                $workdate = date("Y-m-d",strtotime($time['C_Date']));
            
                
                $outTime[$workdate][] = $time['C_Time'];
                
            }
            foreach($intimes as $time)
            {
                $workdate = date("Y-m-d",strtotime($time['C_Date']));
                
                
                $inTime[$workdate]['Time']['IN'][] = $time['C_Time'];
                $inTime[$workdate]['Time']['OUT'] = (!empty($outTime[$workdate]))? $outTime[$workdate] : '';
                $inTime[$workdate]['Card'] = $time['C_Card'];
            }
            
           
            
        }
        $newTime = array();
        
        foreach($inTime as $key=>$experiment){
            
            
            
            if(!empty($experiment['Time']['OUT'])){
                
            $firstInTime = array_shift($experiment['Time']['IN']);
            $newTime[$key]['IN'][] = substr($firstInTime,0,2).':'.substr($firstInTime,2,2).':'.substr($firstInTime,4,6); 
            $time1 = new DateTime($key.' '.substr($firstInTime,0,2).':'.substr($firstInTime,2,2).':'.substr($firstInTime,4,6));
            $min = 0;
            $hour = 0;
            $sec = 0;
            
            foreach($experiment['Time']['OUT'] as $j => $out_t)
            {
                $newTime[$key]['OUT'][] = substr($out_t,0,2).':'.substr($out_t,2,2).':'.substr($out_t,4,6);
                $time2 = new DateTime($key.' '.substr($out_t,0,2).':'.substr($out_t,2,2).':'.substr($out_t,4,6));
                
                $difference = $time2->diff($time1);
                $hour += (int)$difference->format('%h');
                $min += (int)$difference->format('%i');
                $sec += (int)$difference->format('%s');
                if($j == (count($experiment['Time']['OUT'])-1))
                { 
                    if(($min % 60) != 0)
                    {
                       $hour += round($min/60); 
                       $min = $min % 60;
                    }
                    elseif(($sec%60) != 0)
                    {
                        $min += round($sec/60); 
                        $sec = $sec%60;
                    }
                    $newTime[$key]['WT'][] =  $hour.':'.$min; 
                    
                }
                //$newTime[$key]['Diff'][] =  $hour.'hrs '.$min.'min ';  //$difference->format('%h hours %i minutes %s seconds');
                
                foreach($experiment['Time']['IN'] as $k => $in_t)
                {
                    if($j == (count($experiment['Time']['OUT'])-1))
                    { 
                        break;
                    }
                    if($in_t > $out_t && !in_array($in_t,$newTime))
                    {
                        $newTime[$key]['IN'][] = substr($in_t,0,2).':'.substr($in_t,2,2).':'.substr($in_t,4,6);
                        $time1 = new DateTime($key.' '.substr($in_t,0,2).':'.substr($in_t,2,2).':'.substr($in_t,4,6));
                        break;
                    }
                }

            }
            }
        }

          $data['report'] = $newTime;
          $data['dateFrom'] = $this->input->post('dateFrom');
          $data['dateTo'] = $this->input->post('dateTo');
          $data['employee'] = (!empty($employee))? array_shift($employee):'';
          $data['regular_time'] = $this->msettings->get_settings(array('key'=>'RT'));
          require_once APPPATH.'libraries/html2pdf/html2pdf.class.php';
      
          $pdf = new HTML2PDF('P', 'A4', 'en');
          
          $pdf->WriteHTML($this->load->view('report/vreport',$data,true));
          $pdf->Output();

        }
    }
}

?>
