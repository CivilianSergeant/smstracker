<?php

class CampaignRequest
{
    public $CampaignTitle;
    public $TemplateID;
    public $ListID;
    public $SendTime;
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function Validate()
    {
        return new GatewayResponse(100, 'Test');
    }
}