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
           $this->db->where('request_dt',$today);
           $resource = $this->db->get('message_queue');

           $result = $resource->result_array();
           
           $response = array();
           if(!empty($result))
           {
            if($count){
                $newResult = array();
                foreach($result as $key=> $r)
                {
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['date'] = $r['dispatch_dt'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['time'] = $r['dispatch_time'];
                    
                }
                $response['result'] = $newResult;
            }else{
                $response['result'] = count($result);
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
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['date'] = $r['dispatch_dt'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['time'] = $r['dispatch_time'];
                    
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
          //echo $clientId.'/'.$dateFrom.'/'.$dateTo.'<br/>';die('stopped'); 
         
          $dateFrom = date("Y-m-d",strtotime($dateFrom));
          $dateTo = date("Y-m-d",strtotime($dateTo));

          $response = array();
          if($dateFrom && $dateTo)
          {
           $stmt = "SELECT * FROM track_sms WHERE clientId='{$clientId}' AND dispatch_dt BETWEEN '".$dateFrom."' AND '".$dateTo."'";
           $resource = $this->db->query($stmt);
           $result = $resource->result_array();
//           echo '<pre>';
//           print_r($result);
//           echo $this->db->last_query();
           if(!empty($result))
           {
             if($count){
                 $newResult = array();
                foreach($result as $key=> $r)
                {
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['date'] = $r['dispatch_dt'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$r['dispatch_dt']]['time'] = $r['dispatch_time'];
                    
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
          }else{
              return array();
          }
          
    }
    
    public function getSMSDetailsReport($clientId,$date,$masking)
    {
        $this->db->where('clientId',$clientId);
        $this->db->where('dispatch_dt',$date);
        $this->db->where('subject',$masking);
        $result = $this->db->get($this->table);
        return $result->result_array();
    }
    
    /**
     * Get number of sms successfully dispatched
     * @param string $clientId
     * @return array
     */
    public function getSMSBalance($clientId)
    {
        $this->db->where('clientId',$clientId);
        $this->db->like('dispatch_dt',date('Y-m').'-','after');
        $result = $this->db->get($this->table);
        return $result->result_array();
    }
    
    
    
    
}

?>
