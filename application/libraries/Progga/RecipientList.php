<?php

class RecipientList
{
    public $ID = null; //Guid
    public $Name = ''; //{ get; set; }
    public $CreateDate = ''; //DateTime { get; set; }
    public $ClientID = null; //Guid { get; set; }
    public $ContactsCount = null;
    public $LastModified = ''; //DateTime { get; set; }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}