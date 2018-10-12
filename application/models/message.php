<?php
/**
 * Description of Message
 *
 * @author Himel
 */
class message extends CI_Model{
    
    /**
     * Masking or Subject
     * @var string 
     */
    public $subject;
    
    /**
     * Recipient Identity
     * @var string
     */
    public $toWhom;
    
    /**
     * Mobile number
     * @var string
     */
    public $mobileNumber;
    
    /**
     * Message content
     * @var string 
     */
    public $message;
    
    /**
     * Schedule Date Time in string
     * @var string 
     */
    public $scheduleTime;

    /**
     * Line Number specify the gateway / provider
     * @var
     */
    public $lineNumber;
    
    /**
     * Message Length
     * @return int 
     */
    public function messageLen()
    {

        $normalLen = strlen($this->message);
        $newLineCount = substr_count($this->message, "\n");
        $SubStrLen = $normalLen-$newLineCount;
        $newStrLen = $SubStrLen+($newLineCount*2);
        return $newStrLen;
    }
}

?>
