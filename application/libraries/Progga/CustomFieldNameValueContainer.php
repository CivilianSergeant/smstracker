<?php

class CustomFieldNameValueContainer
{
    public $AdditionalKeyItems;
    public $AdditionalValueItems;
    public $CurrentIndex;
    
    public function __construct($size = null)
    {
        $this->CurrentIndex = 0;
        if (!is_null($size)) {
            $this->AdditionalKeyItems = new SplFixedArray($size);
            $this->AdditionalValueItems = new SplFixedArray($size);
        } else {
            $this->AdditionalKeyItems = array();
            $this->AdditionalValueItems = array();
        }
    }
    
    public function AddItem($key, $value)
    {
        $this->AdditionalKeyItems[$this->CurrentIndex] = $key;
        $this->AdditionalValueItems[$this->CurrentIndex] = $value;
        $this->CurrentIndex++;
        return $this;
    }
}