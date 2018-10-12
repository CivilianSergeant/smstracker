<?php
/**
 * Created by PhpStorm.
 * User: Tanvir
 * Date: 12/8/14
 * Time: 12:06 PM
 */
require_once APPPATH.'core/interfaces/IMessageProvider.php';
class ROBI_1 implements IMessageProvider{
    /**
     * Provider given username
     * @var string
     */
    private $_username="Carbon";

    /**
     * Provider given password
     * @var string
     */
    private $_password="Robi@1234";

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
    const PROVIDER = 'ROBI_1';

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

        //  $api  = "https://bmpws.robi.com.bd/ApacheGearWS/SendTextMultiMessage?";
        $api  = "https://bmpws.robi.com.bd/ApacheGearWS/SendTextMessage?";
        $api .= "Username=".$this->_username;
        $api .= "&Password=".$this->_password;
        $api .= "&To="."88".$this->_mobileNumber;
        $api .= "&From=".urlencode($this->maskReConfigure($this->_subject));
        $api .= "&Message=".urlencode($this->_message);

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

        $this->status = (string)$response;

        $this->statusMessage = (string)$response;

        return $this;
    }


    public function getMaskList()
    {
        // mask list as per provider provided.
        return array(
            'CBC',
            'RADIANT',
            'AUNKUR SCL',
            'ORKIDS',
            'CSBH',
            'SSBH',
            'MASTERMIND',
            'CARBON INT',
            'Ispahani',
            '8801847099498'
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
                $newMask = 'RADIANT';
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
                $newMask = '8801847099498';

        }

        return $newMask;
    }
} 