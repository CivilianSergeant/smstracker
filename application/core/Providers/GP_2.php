<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/8/14
 * Time: 12:06 PM
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';
class GP_2 implements IMessageProvider{
    /**
     * Provider given username
     * @var string
     */
    private $_username="c51apiuser";

    /**
     * Provider given password
     * @var string
     */
    private $_password="@f!g12Qx";

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
    const PROVIDER = 'GP_2';

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

        $api  = "https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?";
        $api .= "username=".$this->_username;
        $api .= "&password=".$this->_password;
        $api .= "&msisdn=".$this->_mobileNumber;
        $api .= "&cli=".urlencode($this->maskReConfigure($this->_subject));
        $api .= "&message=".urlencode($this->_message);
        $api .= "&apicode=1&countrycode=1&messagetype=1&messageid=0";

        return $api;
    }

    /**
     * Strip 0 or 880 from number
     * @param $number
     * @return string
     */
    protected function stripZero($number)
    {
        if(preg_match('/^0/',$number))
        {
            return substr($number,1,strlen($number));

        }else if(preg_match('/^880/',$number)){

            return substr($number,3,$number);

        }else{
            return $number;
        }
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
     * @status SMS sent | Failed!!!
     */
    public function sendSMS()
    {

        $response = @file_get_contents($this->getProviderRequestUrl());
        $xml_response = simplexml_load_string($response);

        $this->status = $xml_response->status;
        $this->statusMessage = (string)$xml_response->remarks;

        return $this;
    }


    public function getMaskList()
    {
        return array(
            'SCHOOL',
            'RAOZAN CLUB',
            'CBC',
            'COLLEGE',
            'RadiantRSC',
            'AUNKUR SCL',
            'ORKIDS',
            'CSBH',
            'SSBH',
            'MASTERMIND',
            'CARBON INT'
        );
    }

    // User to re configure mask(as defined in our system) if the mask vary from provider to provider
    public function maskReConfigure($mask)
    {
        $newMask = '';
        switch($mask){
            case'CBC':
                $newMask = 'CBC';
                break;
            case'RadiantRSC':
                $newMask = 'RadiantRSC';
                break;
            case'AUNKUR SCL':
                $newMask = 'AUNKUR SCL';
                break;
            case'ORKIDS':
                $newMask = 'ORKIDS';
                break;
            case'CSBH':
                $newMask = 'CSBH';
                break;
            case'SSBH':
                $newMask = 'SSBH';
                break;
            case'MASTERMIND':
                $newMask = 'MASTERMIND';
                break;
            case'CARBON INT':
                $newMask = 'CARBON INT';
                break;
            default:
                $newMask = 'CARBON INT';

        }

        return $newMask;
    }
} 