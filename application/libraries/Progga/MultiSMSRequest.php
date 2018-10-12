<?php

class MultiSMSRequest
{   
    public $Messages = null;
    public $MessageIDs = null;
    public $CampaignTitle = '';
    public $SenderIDs = null;
    public $MobileNumbers = null;
    public $SendTime = '';
    public $ContentType = null;
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __construct($campaignTitle, $sendTime, $messageIDs, $senderIDs, $mobileNumbers, $messages, $ContentType)
    {
        $sendTime = $sendTime-21600;
        $timeFormat = $sendTime*1000;
        $this->CampaignTitle = $campaignTitle;
        $this->SendTime =  "/Date(" . $timeFormat . ")/";
        $this->MobileNumbers = $mobileNumbers;
        $this->Messages = $messages;
        $this->ContentType = $ContentType;
        $this->MessageIDs = $messageIDs;
        $this->SenderIDs = $senderIDs;
    }
   public function Validate()
    {
        return new GatewayResponse(100, 'Test');
    }
    
 }
