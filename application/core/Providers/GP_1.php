<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/8/14
 * Time: 12:06 PM
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';
class GP_1 implements IMessageProvider{
    /**
     * Provider given username
     * @var string
     */
    private $_username="CLTDadmin";

    /**
     * Provider given password
     * @var string
     */
    private $_password="CLTDadmin123";

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
    const PROVIDER = 'GP_1';

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

        $api  = "https://cbsms.grameenphone.com/send_sms_api/send_sms_from_api.php?";
        $api .= "user_name=".$this->_username;
        $api .= "&password=".$this->_password;
        $api .= "&subscriber_no=".$this->stripZero($this->_mobileNumber);
        $api .= "&mask=".urlencode($this->maskReConfigure($this->_subject));
        $api .= "&sms=".urlencode($this->_message);

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
            'School',
            'College',
            'RadiantRSC',
            'ORKIDS',
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
                $newMask = 'College';
                break;
            case'RadiantRSC':
                $newMask = 'RadiantRSC';
                break;
            case'AUNKUR SCL':
                $newMask = 'College';
                break;
            case'ORKIDS':
                $newMask = 'ORKIDS';
                break;
            case'CSBH':
                $newMask = 'College';
                break;
            case'SSBH':
                $newMask = 'College';
                break;
            case'MPCC':
                $newMask = 'College';
                break;
            case 'College':
                $newMask = 'College';
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