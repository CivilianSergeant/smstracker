<?php
/**
 * Description of msg21
 *
 * @author Himel
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';

class Msg21 {
    
    /**
     * Provider given username
     * @var string 
     */
    private $_username="bengal";
    
    /**
     * Provider given password
     * @var string 
     */
    private $_password="123456";
    
    /**
     * Message Send to 
     * @var string 
     */
    private $_mobileNumber;
    
    /**
     * Message Masking
     * @var string 
     */
    private $_subject;
    
    /**
     * Message Body
     * @var String 
     */
    private $_message;
    
    /**
     * Message Status
     * @var boolean 
     */
    public  $status;
    
    /**
     * Message Status feedback message
     * @var string 
     */
    public  $statusMessage;
    
    /**
     * Provider Name
     */
    const PROVIDER = 'MSG21';
    
    /**
     * Provide Name 
     * @return string 
     */
    public function getProviderName()
    {
        return self::PROVIDER;
    }
    
    /**
     * Define Provider Request Url
     * 
     * @return string;
     */
    public function getProviderRequestUrl() {
        
        $api  = 'http://msg21.com/users/smsapi?';
        $api .= 'username='.$this->_username;
        $api .= '&password='.$this->_password;
        $api .= '&destination=88'.$this->_mobileNumber;
        $api .= '&source='.urlencode($this->_subject);
        $api .= '&message='.urlencode($this->_message);
       
        return $api;
    }
    
    /**
     * Set mobile number
     * @param string $mobileNumber
     * @return Airtel 
     */
    public function setMobileNo($mobileNumber)
    {
        $this->_mobileNumber = $mobileNumber;
        return $this;
    }
    
    
    /**
     * Set Message 
     * @param string $message
     * @return Airtel 
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }
    
    /**
     * Set Message Subject or Masking
     * @param string $subject
     * @return Airtel 
     */
    public function setSubject($subject)
    {
        $this->_subject =  $subject;
        return $this;
    }
    
    /**
     * Sms Send Process
     * @return Msg21 
     */
    public function sendSMS()
    {
       $response = @file_get_contents($this->getProviderRequestUrl());
       
       if(preg_match('/queued/',$response)){
           $this->status = true;
           $this->statusMessage = 'Success';
       }else{
           $this->status = false;
           $this->statusMessage = 'Failed';
       }
       return $this; 
    }
}

?>
