<?php
/**
 * Description of TrackSms
 *
 * @author Himel
 */
class TrackSms {
    
    /**
     * Queue Id
     * @var int 
     */
    public $queue_id;
    
    /**
     * Client Id
     * @var string 
     */
    public $clientId;
    
    /**
     * SMS Send to
     * @var string 
     */
    public $number;
    
    /**
     * Masking Used
     * @var string 
     */
    public $subject;
    
    /**
     * Recipient Identity
     * @var string 
     */
    public $to_whom;
    
    /**
     * Message Send
     * @var string 
     */
    public $message;

    /**
     * Message Length
     * @var string
     */
    public $message_length;
    
    /**
     * Sms Provider Used
     * @var string 
     */
    public $provider;
    
    /**
     * SMS Status
     * @var string 
     */
    public $status;
    
    /**
     * Dispatch Date
     * @var string 
     */
    public $dispatch_dt;
    
    /**
     * Dispatch Time
     * @var string 
     */
    public $dispatch_time;
    
    /**
     * Array format of object
     * @return array 
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}

?>
