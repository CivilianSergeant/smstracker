<?php
/**
 * Description of MessageQueue
 *
 * @author Himel
 */
class MessageQueue extends CI_Model{
    
    /**
     * Message Queue Table Name
     * @var string
     */
    private $_table='message_queue';
    
    /**
     * Message bunch limit for processor
     */
    const BUNCH_LIMIT = 60;
    
    /**
     *  Day Limit
     */
    const DAY_LIMIT = 5;
    
    /**
     *  E-mail address for notification 
     */
    const TO = 'tanvir@carbon51.com';
    
    /**
     *  Subject for E-mail notification
     */
    const SUBJECT = 'SMS App Warning!';
    
    /**
     * Collection of fetched messages
     * @var array 
     */
    private $_messages = array();
    
    
    
    /**
     * Store Message into database.
     * @param string $clientId
     * @param string $message
     * @return boolean 
     */
    public function storeMessage($clientId,Message $message)
    {
        error_reporting(0);
        date_default_timezone_set('Asia/Dhaka');
        $value = array(
            'clientId' => mysql_real_escape_string($clientId),
            'number' => mysql_real_escape_string($message->mobileNumber),
            'subject' => mysql_real_escape_string($message->subject),
            'to_whom' => mysql_real_escape_string($message->toWhom),
            'message' => mysql_real_escape_string($message->message),
            'line_number'=> $message->lineNumber,
            'message_length' => $message->messageLen(),
            'message_status' => 0,
            'queue_status' => 0,
            'schedule_time' => (!empty($message->scheduleTime))? $message->scheduleTime : "",
            'request_dt' => date('Y-m-d'),
            'request_time' => date('H:i:s')
        );
        $this->db->insert($this->_table,$value);
        return $this->db->insert_id();
    }
    
    /**
     * Check if Day Limit Exceded 
     * @return int 
     */
    public function checkDayLimit()
    {
        $this->db->where(array('message_status'=>0,'queue_status'=>0));
        return $this->db->count_all_results($this->_table);
    }
    
    /**
     * Get the day limit 
     * @return int 
     */
    public function getDayLimit()
    {
       return self::DAY_LIMIT; 
    }
    
    
    
    /**
     *
     * @param int $bunchLimit
     * @return array 
     */
    protected function getMessages($bunchLimit=self::BUNCH_LIMIT)
    {
        if(empty($this->_messages))
        {
            $this->db->where(array('message_status'=>0,'queue_status'=>0));
            $this->db->group_by(array('number','message'));
            $this->db->order_by('message_queue_id','DESC');
            $this->db->limit($bunchLimit);
            $result = $this->db->get($this->_table);
                $this->_messages = $result->result();
        }
        return $this->_messages;
    }
    
    
    
    /**
     * Clear Message Collection
     * @return MessageQueue 
     */
    protected function clearMessageCollection()
    {
        $this->_messages = array();
        return $this;
    }

    /**
     * Immediately change Queued Item after get bunch
     * @return boolean
     */
    protected function UpdateQueueStatus()
    {
        $this->getMessages();
        if(!empty($this->_messages))
        {
            foreach($this->_messages as $message)
            {
                $scheduleTime = strtotime($message->schedule_time);
                if(time() <  $scheduleTime)
                    continue;
                $this->db->update($this->_table,array('queue_status' => 1),array('message_queue_id' => $message->message_queue_id));
            }
            return true;
        }
        return false;
    }
    
    
}

?>
