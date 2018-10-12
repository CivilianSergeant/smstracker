<?php
/**
 * Description of SmsReport
 *
 * @author Himel
 */
class SmsReport extends CI_Model{
    
    private $table="track_sms";
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get Report of today
     * @param type $clientId
     * @param type $today
     * @return json 
     */
    public function getReportToday($clientId,$today='',$count=false)
    {
           date_default_timezone_set('Asia/Dhaka');
           $date = $today;
           
           $today = (!empty($date))? $date : date("Y-m-d");

           $this->db->where('clientId',$clientId);
           $this->db->where('dispatch_dt',$today);
           $resource = $this->db->get($this->table);

           $result = $resource->result_array();
           
           $response = array();
           if(!empty($result))
           {
            if($count){
                $response['message'] = $result[0]['message'];
                $response['result'] = count($result);
            }else{
                $response['result'] = $result;
            }
            
            $response['status'] = 200;
           }
           else
           {
            $response['result'] = 0;   
            $response['status'] = 500;
           }
           
           return $response;
    }
    
    /**
     * Get Report By Duration Like Last day, Last 7 Day, Last month or 30 day
     * @param type $clientId
     * @param type $duration
     * @return json 
     */
    public function getReportByDuration($clientId,$duration,$count=false)
    {
       
        if(is_numeric($duration))
        {
            $duration = (int)$duration;
        }else{
            $duration = 1;
        }
        $stmt = "SELECT * FROM track_sms
                WHERE clientId='{$clientId}' AND `dispatch_dt` > CURRENT_DATE - INTERVAL {$duration} DAY";
        $resource = $this->db->query($stmt);
        $result = $resource->result_array();
        $response = array();
           if(!empty($result))
           {
            if($count){
                $newResult = array();
                foreach($result as $key=> $r)
                {
                    $newResult[$r['dispatch_dt']]['messageContent'] = $r['message'];
                    $newResult[$r['dispatch_dt']]['messageLen'] = strlen($r['message']).' Chars / '.ceil(strlen($r['message'])/160). 'sms';
                    $newResult[$r['dispatch_dt']]['numSmsCount'] = ($key+1);
                    $newResult[$r['dispatch_dt']]['date'] = $r['dispatch_dt'];
                    $newResult[$r['dispatch_dt']]['time'] = $r['dispatch_time'];
                    
                }
                $response['result'] = $newResult;
            }else{
                $response['result'] = $result;
            }   
            
            $response['status'] = 200;
           }
           else
           {
            $response['result'] = 0;   
            $response['status'] = 500;
           }
           return $response;
    }
    
    /**
     * Get Report Between Two Date For custom Search
     * @param type $clientId
     * @param type $dateFrom
     * @param type $dateTo
     * @return json 
     */
    public function getReportBetweenDate($clientId,$dateFrom,$dateTo,$count=false)
    {
          $dateFrom = date("Y-m-d",strtotime(mysql_real_escape_string($dateFrom)));
          $dateTo = date("Y-m-d",strtotime(mysql_real_escape_string($dateTo)));

          $response = array();
          if($dateFrom && $dateTo)
          {
           $stmt = "SELECT * FROM track_sms WHERE clientId='{$clientId}' AND dispatch_dt BETWEEN '".$dateFrom."' AND '".$dateTo."'";
           $resource = $this->db->query($stmt);
           $result = $resource->result_array();

           if(!empty($result))
           {
             if($count){
                 $response['message'] = $result[0]['message'];
                 $response['result'] = count($result);
             }else{
                 $response['result'] = $result;
             }
             
             $response['status'] = 200;
           }
           else
           {
             $response['result'] = 0;  
             $response['status'] = 500;
           }
              return $response;
          }else{
              return array();
          }
          
    }
    
    
}

?>
