<?php
/**
 * Created by PhpStorm.
 * User: Himel
 * Date: 4/20/14
 * Time: 11:27 AM
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';

class BulkSms implements IMessageProvider{

    /**
     * Provider given username
     * @var string
     */
    private $_username="tanvir";

    /**
     * Provider given password
     * @var string
     */
    private $_password="ADI06bMp";

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
    const PROVIDER = 'BulkSms';

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

        $api  = "http://66.45.237.70/api.php?";
        $api .= "username=".$this->_username;
        $api .= "&password=".$this->_password;
        $api .= "&number=88".$this->_mobileNumber;
        $api .= "&sender=".urlencode($this->_subject);
        $api .= "&type=0&message=".urlencode($this->_message);

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

        if(is_array($status))
        {
            $this->status = true;
            $this->statusMessage = $response;
        }
        else
        {

            switch(trim($status))
            {
                case "1001":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Number Error';
                    break;
                case "1002":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Sender Name Error';
                    break;
                case "1003":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Message Error';
                    break;
                case "1004":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Parameter Error';
                    break;
                case "1005":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Username & Password Error';
                    break;
                case "1006":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Account Balance Error';
                    break;
                case "1007":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Account Validity Error';
                    break;
                case "1008":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Operator Status Error';
                    break;
                case "1009":
                    $this->status = true;
                    $this->statusMessage = trim($status). 'Account Status Error';
                    break;
            }
        }

        return $this;
    }


    // User to re configure mask(as defined in our system) if the mask vary from provider to provider
    public function maskReConfigure($mask)
    {
        // method not implemented
    }
} 