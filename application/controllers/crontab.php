<?php
/**
 * Description of crontab
 *
 * @author Himel
 */

class Crontab extends CI_Controller{
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->model('message');
        $this->load->model('messagequeue');
        $this->load->model('messageprocessor');
    }
    
    public function index()
    {
       $this->messageprocessor->sendRequestToProvider();
    }
    
    
}

?>
