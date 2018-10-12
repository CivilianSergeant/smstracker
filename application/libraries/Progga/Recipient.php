<?php

class Recipient
{
    public $MobileNumber;
    public $AdditionalFields;
    public $ListID;
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}