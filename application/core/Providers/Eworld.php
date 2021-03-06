<?php
/**
 * Description of Eworld
 *
 * @author Himel
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';

class Eworld implements IMessageProvider{
    
    /**
     * Provider given username
     * @var string 
     */
    private $_username="carbon";
    
    /**
     * Provider given password
     * @var string 
     */
    private $_password="ew51";
    
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
    const PROVIDER = 'Eworld';
    
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
        
        $api  = "http://www.eworldbd.com/sms/sendsms.aspx?";
        $api .= "username=".$this->_username;
        $api .= "&password=".$this->_password;
        $api .= "&mobileNo=88".$this->_mobileNumber;
        $api .= "&Masking=".urlencode($this->_subject);
        $api .= "&SMS=".urlencode($this->_message);
       
        return $api;
    }
    
    /**
     * Set mobile number
     * @param string $mobileNumber
     * @return Eworld 
     */
    public function setMobileNo($mobileNumber)
    {
        $this->_mobileNumber = $mobileNumber;
        return $this;
    }
    
    
    /**
     * Set Message 
     * @param string $message
     * @return Eworld 
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }
    
    /**
     * Set Message Subject or Masking
     * @param string $subject
     * @return Eworld 
     */
    public function setSubject($subject)
    {
        $this->_subject =  $subject;
        return $this;
    }
    
    /**
     * Sms Send Process
     * @return Eworld
     */
    public function sendSMS()
    {
        $response = @file_get_contents($this->getProviderRequestUrl());
        $status = explode("|",$response);
        
        $errorMsg = '';
        
           switch($status[0])
           {
               case "1701":
                   $this->status = true;
                   $this->statusMessage = substr($status[2],0,37); 
                   break;
               case "1702":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid URL Error';
                   break;
               case "1703":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid User Name Or Password';
                   break;
               case "1704":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid SMS Type';
                   break;
               case "1705":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid SMS Body';
                   break;
               case "1706":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid Destination Mobile Number';
                   break;
               case "1707":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Invalid Sender';
                   break;
               case "1709":
                   $this->status = false;
                   $this->statusMessage = $status[0].' User Validation failed';
                   break;
               case "1710":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Internal Error';
                   break;
               case "1025":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Insufficient Credit';
                   break;
               case "1725":
                   $this->status = false;
                   $this->statusMessage = $status[0].' Gateway Response Timeout';
                   break;
           }
           return $this;
    }

    /**
     * Check Available Balance
     * @return string
     */
    public function getBalanceAvailable()
    {
        $ch = curl_init();
        $url = 'http://eworldbd.com/API/Service.asmx';

        $postData = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <Balance xmlns="http://tempuri.org/">
              <username>'.$this->_username.'</username>
              <password>'.$this->_password.'</password>
            </Balance>
          </soap12:Body>
        </soap12:Envelope>';

        // Set url
        curl_setopt($ch, CURLOPT_URL , $url);

        // set Request Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/soap+xml; charset=utf-8','Content-Length:'.strlen($postData)));
        // set Post Data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Return the transfer as string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        $doc = new DOMDocument();
        $doc->loadXML($output);
        $balanceResults = $doc->getElementsByTagName('BalanceResult');
        return $balanceResults->item(0)->nodeValue;
    }

}

?>
