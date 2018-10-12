<?php
require_once 'GatewayResponse.php';

class TextMessageRequest
{
    public $ID = '';
    
    public $MessageBody = '';
    
    public $SendTime = '';
    
    public $MobileNumber = '';

    public function __construct($id, $mobileNumber, $messageBody, $sendTime)
    {
        $sendTime = $sendTime-21600;
        $timeFormat = $sendTime*1000;
        $this->ID = $id;
        $this->MobileNumber = $mobileNumber;
        $this->MessageBody = $messageBody;
        $this->SendTime = "/Date(" . $timeFormat . ")/";
    }

    public function Validate($code)
    {
        return new GatewayResponse($code, 'Test');
    }
}
