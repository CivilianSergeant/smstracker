<?php

class GatewayResponse
{
    public $Code = null;
    public $Message = '';
    
    public function __construct($code = null, $msg = '')
    {
        $this->Code = $code;
        $this->Message = $msg;
    }
}
