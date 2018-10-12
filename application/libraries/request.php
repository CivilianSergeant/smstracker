<?php
/**
 * Description of request
 *
 * @author Himel
 */
class Request {
    
    public function __construct() {
        //;
    }
    
    public function is_Get()
    {
        if(!empty($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'get')
            return true;
        else
            return false;
    }
    
    public function is_Post()
    {
        if(!empty($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post')
            return true;
        else
            return false;
    }
    
    public function is_XmlHttpRequest()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;
        else
            return false;
            
    }
}

?>
