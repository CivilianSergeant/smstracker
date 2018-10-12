<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/26/14
 * Time: 2:03 PM
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';

class WiselySend implements IMessageProvider{
    /**
     * Provider given username
     * @var string
     */
    private $_username="test";

    /**
     * Provider given password
     * @var string
     */
    private $_password="test123";

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
    const PROVIDER = 'WiselySend';

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


        $api  = 'http://www.wiselysend.com:8080/HTTP.svc/SendSMS?apipublickey=1623713419&apiprivatekey=gAMB]a3';
        $api .= '&sender='.urlencode($this->_subject);
        /*$api .= 'username='.$this->_username.'&password='.$this->_password;*/
        $api .= '&receiver=88'.$this->_mobileNumber.'&text='.urlencode($this->_message).'&type=1';

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

        $responseArray = explode(",",$response);
        if(preg_match('/Accepted/',$responseArray[2])){

            $this->status = true;
            $this->statusMessage = $response;
        }
        else if(preg_match('/Rejected/',$responseArray[2]))
        {
            $this->status = false;
            $this->statusMessage = $response;
        }
        else
        {
            $this->status = false;
            $this->statusMessage = 'Failed. '.$response;
        }

        return $this;
    }
} 