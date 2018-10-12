<?php

/**
 * Description of test
 *
 * @author Himel
 */
require_once APPPATH.'core/Providers/Eworld.php';
class Test extends CI_Controller{
   
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        
        $this->load->model('Message');
        $this->load->model('MessageQueue');
        $this->load->model('MessageProcessor');
    }
    
    public function index()
    {
        error_reporting(E_ALL);       
//        echo '<pre>';
//        $this->load->helper('function');
       // $messageProcessor = new MessageProcessor();
        ///$messageProcessor->setProvider(new Eworld());
        //$messageProcessor->sendRequestToProvider();
//        echo generateClientId();
    }
    
    
    
    
    
    
   
    
    
}

?>
