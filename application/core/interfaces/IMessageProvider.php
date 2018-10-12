<?php
/**
 * Description of IMessageProvider
 *
 * @author Himel
 */
interface IMessageProvider {
    
    /**
     * Set Mobile Number
     */
    public function setMobileNo($mobileNumber);
    
    /**
     * Set Message
     */
    public function setMessage($message);
    
    /**
     * Set Subject or Masking
     */
    public function setSubject($subject);
    
    /**
     * Get Provider Name
     */
    public function getProviderName();
    
    /**
     * Retrieve Request URL for provider
     */
    public function getProviderRequestUrl(); 
    
    /**
     * Send Defination
     */
    public function sendSMS();

    /**
     * User to re configure mask(as defined in our system) if
     * the mask vary from provider to provider
     */
    public function maskReConfigure($mask);





}

?>
