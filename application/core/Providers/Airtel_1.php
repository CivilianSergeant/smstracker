<?php
/**
 * Description of MessageProvider
 *
 * @author Himel
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';

class Airtel_1 implements IMessageProvider {
   
    /**
     * Provider given username
     * @var string 
     */
    private $_username="01610558810";
    
    /**
     * Provider given password
     * @var string 
     */
    private $_password="a193990034x";
    
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
    const PROVIDER = 'Airtel';
    
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
        
        $api  = 'http://portals.bd.airtel.com/msdpapi?REQUESTTYPE=SMSSubmitReq';
        $api .= '&USERNAME='.$this->_username.'&PASSWORD='.$this->_password;
        $api .= '&MOBILENO='.$this->_mobileNumber.'&MESSAGE='.urlencode($this->_message);
        $api .= '&TYPE=0&ORIGIN_ADDR='.urlencode($this->_subject);
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
     * @return Airtel 
     */
    public function sendSMS()
    {
        $response = @file_get_contents($this->getProviderRequestUrl());
        
        if(preg_match('/Accepted/',$response)){
            $responseArray = explode(" ",$response);
            $this->status = true;
            $this->statusMessage = $responseArray[1];
        }
        else
        {
            $this->status = false;
            $this->statusMessage = 'Failed. '.$response; 
        }
        
        return $this;
    }
    
    
    
}

?>
