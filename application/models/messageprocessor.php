<?php
/**
 * Description of MessageProcessor
 * 
 * @author Himel
 */

class MessageProcessor extends MessageQueue{
    
    /**
     * Provider instance
     * @var IMessageProvider 
     */
    private $_provider;
    
    /**
     * Collection of sms feedback
     * @var array 
     */
    private $_feedback = array();
    
    /**
     * Send Sms Request To Provider
     * @return boolean 
     */
    public function sendRequestToProvider()
    {
        error_reporting(E_ALL);
       date_default_timezone_set('Asia/Dhaka');
       $this->load->model('tracksms');
       $this->load->model('msettings');
       
       $SMS_DAY_LIMIT = $this->msettings->get_settings(array('key'=>'SMS_DAY_LIMIT'));
       if(!empty($SMS_DAY_LIMIT)){
           if($SMS_DAY_LIMIT['value'] == 1)
               return 0;
       }

       /*if($this->_provider)
       {*/
           $this->UpdateQueueStatus();
           $messages = $this->getMessages();
           if(!empty($messages)){
               foreach($messages as $message){
                   $scheduleTime = strtotime($message->schedule_time);
                   if(time() <  $scheduleTime)
                       continue;

                   $className = $message->line_number;

                   if(file_exists(APPPATH.'core/Providers/'.$className.'.php')){

                       require_once APPPATH.'core/Providers/'.$className.'.php';

                       $this->_provider = new $className();

                        $this->_provider->setMobileNo($message->number);
                        $this->_provider->setSubject($message->subject);
                        $messageStr = str_replace('\n',' ',$message->message);
                        $messageStr = str_replace('\\','',$messageStr);
                        $this->_provider->setMessage($messageStr);
                        $smsStatus = $this->_provider->sendSMS();


                       $trackSms = new TrackSms();
                       $trackSms->queue_id = $message->message_queue_id;
                       $trackSms->clientId = $message->clientId;
                       $trackSms->number   = $message->number;
                       $trackSms->subject  = $message->subject;
                       $trackSms->to_whom  = $message->to_whom;
                       $trackSms->message  = urlencode($messageStr);
                       $trackSms->message_length = $message->message_length;
                       $trackSms->provider = $this->_provider->getProviderName();

                       $trackSms->status   = (!empty($smsStatus->statusMessage))? $smsStatus->statusMessage : '';
                       $trackSms->dispatch_dt = date('Y-m-d');
                       $trackSms->dispatch_time = date('H:i:s');
                       $this->_feedback[] = $trackSms;

                   }else{

                       file_put_contents('sms_error.log',$className.' class not found');
                   }

               }

               $this->_storeFeedBack();
               $this->clearMessageCollection();
               return true;
           }


       //}
       return false;
    }
    
    /**
     * Store SMS Feedback
     * @return boolean 
     */
    protected function _storeFeedBack()
    {

       if(!empty($this->_feedback))
       {
           foreach($this->_feedback as $k=> $track){

               $this->db->insert('track_sms',$track->getArrayCopy());
               $this->db->update('message_queue',array('message_status'=>1),array('message_queue_id'=>$track->queue_id));
               unset($this->_feedback[$k]);
           }
           return true;
       }
       return false;
    }


    
    /**
     * Set Provider Instance
     * @param IMessageProvider $provider
     * @return MessageProcessor 
     */
    public function setProvider(IMessageProvider $provider)
    {
        $this->_provider = $provider;
        return $this;
    }

}

?>
