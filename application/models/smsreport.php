<?php
/**
 * Description of SmsReport
 *
 * @author Himel
 */
class SmsReport extends CI_Model{
    
    private $table="track_sms";
    private $table2 = "message_queue";
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /**
     * Get Report of today
     * @param type $clientId
     * @param type $today
     * @return json 
     */
    public function getReportToday($clientId,$today='',$count=false,$reportFrom=null)
    {
           date_default_timezone_set('Asia/Dhaka');
           $date = $today;
           
           $today = (!empty($date))? $date : date("Y-m-d");

           $this->db->where('clientId',$clientId);

           if($reportFrom == null)
           {
               $this->db->where('dispatch_dt',$today);
               $resource = $this->db->get($this->table);
           }
           else{
               $this->db->where('request_dt',$today);
               $resource = $this->db->get($this->table2);
           }

           $result = $resource->result_array();
           
           $response = array();
           if(!empty($result))
           {
            if($count){
                $newResult = array();
                foreach($result as $key => $r)
                {
                    $sendDate = ($reportFrom ==null)? $r['dispatch_dt'] : $r['request_dt'];
                    $sendTime = ($reportFrom ==null)? $r['dispatch_time'] : $r['request_time'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['date'] = $sendDate;
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['time'] = $sendTime;
                    
                }
                $response['result'] = $newResult;
            }else{
                $countNumber = 0;
                foreach($result as $key => $r)
                {
                   $countNumber +=ceil(strlen(urldecode($r['message']))/160);
                }

                $response['result'] = $countNumber;
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
    public function getReportByDuration($clientId,$duration,$count=false,$reportFrom=null)
    {

        if(is_numeric($duration))
        {
            $duration = (int)$duration;
        }else{
            $duration = 1;
        }
        $table = ($reportFrom == null)? $this->table : $this->table2;
        $field = ($reportFrom == null)? 'dispatch_dt' : 'request_dt';
        $stmt = "SELECT * FROM {$table}
                WHERE clientId='{$clientId}' AND {$field} > CURRENT_DATE - INTERVAL {$duration} DAY";
        $resource = $this->db->query($stmt);
        $result = $resource->result_array();

        $response = array();
           if(!empty($result))
           {
            if($count){
                $newResult = array();
                foreach($result as $key=> $r)
                {
                    $sendDate = ($reportFrom ==null)? $r['dispatch_dt'] : $r['request_dt'];
                    $sendTime = ($reportFrom ==null)? $r['dispatch_time'] : $r['request_time'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['date'] = $sendDate;
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['time'] = $sendTime;

                }
                $response['result'] = $newResult;
            }else{

                $countNumber = 0;
                foreach($result as $key => $r)
                {
                    $countNumber +=ceil(strlen(urldecode($r['message']))/160);
                }

                $response['result'] = $countNumber;
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
    public function getReportBetweenDate($clientId,$dateFrom,$dateTo,$count=false,$reportFrom=null)
    {
          //echo $clientId.'/'.$dateFrom.'/'.$dateTo.'<br/>';die('stopped'); 
         
          $dateFrom = date("Y-m-d",strtotime($dateFrom));
          $dateTo = date("Y-m-d",strtotime($dateTo));

          $response = array();
          if($dateFrom && $dateTo)
          {
           $table = ($reportFrom == null)? $this->table : $this->table2;
           $field = ($reportFrom == null)? 'dispatch_dt' : 'request_dt';
           $stmt = "SELECT * FROM {$table} WHERE clientId='{$clientId}' AND {$field} BETWEEN '".$dateFrom."' AND '".$dateTo."'";
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
                    $sendDate = ($reportFrom == null)? $r['dispatch_dt'] : $r['request_dt'];
                    $sendTime = ($reportFrom == null)? $r['dispatch_time'] : $r['request_time'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageContent'] = $r['message'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['messageLen'] = strlen(urldecode($r['message'])).' Chars / '.ceil(strlen(urldecode($r['message']))/160). 'sms';
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['numSmsCount'] += ceil(strlen(urldecode($r['message']))/160);
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['clientId'] = $r['clientId'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['masking'] = $r['subject'];
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['date'] = $sendDate;
                    $newResult[str_replace(" ","",$r['subject']).'_'.$sendDate]['time'] = $sendTime;
                    
                }
                $response['result'] = $newResult;
             }else{
                 $countNumber = 0;
                 foreach($result as $key => $r)
                 {
                     $countNumber +=ceil(strlen(urldecode($r['message']))/160);
                 }

                 $response['result'] = $countNumber;
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
    
    public function getSMSDetailsReport($clientId,$date,$masking,$reportFrom = null)
    {
        $this->db->where('clientId',$clientId);
        $this->db->where('subject',$masking);
        if($reportFrom == null)
        {
            $this->db->where('dispatch_dt',$date);
            $result = $this->db->get($this->table);

        }else{

            $this->db->where('request_dt',$date);
            $result = $this->db->get($this->table2);
        }

        return $result->result_array();
    }
    
    
}

?>
